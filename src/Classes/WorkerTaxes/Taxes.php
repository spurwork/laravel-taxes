<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;

class Taxes
{
    private $tax_manager;
    private $wage_manager;
    private $area_income_manager;
    private $taxable_income_manager;
    private $tax_override_manager;
    private $bind_manager;

    public function __construct(
        TaxManager $tax_manager,
        WageManager $wage_manager,
        TaxableIncomeManager $taxable_income_manager,
        AreaIncomeManager $area_income_manager,
        TaxOverrideManager $tax_override_manager,
        BindManager $bind_manager
    ) {
        $this->tax_manager = $tax_manager;
        $this->wage_manager = $wage_manager;
        $this->area_income_manager = $area_income_manager;
        $this->taxable_income_manager = $taxable_income_manager;
        $this->tax_override_manager = $tax_override_manager;
        $this->bind_manager = $bind_manager;
    }

    public function calculate(
        Carbon $start_date,
        Carbon $end_date,
        Carbon $pay_date,
        GeoPoint $home_location,
        GeoPoint $suta_location,
        Collection $wages,
        Collection $annual_wages,
        Collection $annual_taxable_wages,
        Collection $annual_liability_amounts,
        $user,
        ?Carbon $birth_date,
        int $pay_periods,
        Collection $reciprocal_agreements,
        Collection $disabled_taxes,
        Collection $exemptions,
        $pay_periods_exempt,
        Collection $worker_comp_rates,
        Collection $suta_rates
    ): Collection {
        $wages_by_lat_long = $this->wage_manager->groupLatLong($wages);
        $annual_wages_by_lat_long = $this->wage_manager->groupLatLong($annual_wages);

        $area_incomes = $this->area_income_manager
            ->groupWagesByGovernmentalArea($wages_by_lat_long, $annual_wages_by_lat_long);

        $home_areas = $this->area_income_manager->getHomeAreas($home_location);

        $parameters = [
            'date' => $start_date,
            'user' => $user,
            'birth_date' => $birth_date,
            'pay_periods' => $pay_periods,
            'area_incomes' => $area_incomes,
            'home_areas' => $home_areas,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'pay_date' => $pay_date,
            'annual_taxable_wages' => $annual_taxable_wages,
            'annual_liability_amounts' => $annual_liability_amounts,
            'total_earnings' => $this->wage_manager->calculateEarnings($wages),
            'minutes_worked' => $this->wage_manager->calculateMinutesWorked($wages),
            'is_salaried' => $this->wage_manager->isSalaried($wages),
            'pay_periods_exempt' => $pay_periods_exempt,
            'workers_comp_rates' => $worker_comp_rates,
            'suta_rates' => $suta_rates,
        ];

        $payroll = new Payroll($parameters, $this->wage_manager, $this->tax_manager);
        $this->bind_manager->bindPayroll($payroll);

        $taxable_incomes = $this->taxable_income_manager->groupWagesByTax(
            $home_location,
            $wages_by_lat_long,
            $annual_wages_by_lat_long
        );

        $this->tax_override_manager->replaceSutaUnemploymentTaxes(
            $suta_location,
            $taxable_incomes,
            $wages,
            $annual_wages
        );
        $this->tax_override_manager->addStateIncomeTax(
            $home_location,
            $taxable_incomes,
            $wages,
            $annual_wages
        );
        $this->tax_override_manager->processReciprocalAgreements($reciprocal_agreements, $taxable_incomes);
        $this->tax_override_manager->removeDisabledTaxes($disabled_taxes, $taxable_incomes);

        $this->taxable_income_manager->processExemptions($taxable_incomes, $exemptions);

        $this->bind_manager->bindTaxes($taxable_incomes);
        $tax_results = $this->tax_manager->computeTaxes($payroll, $taxable_incomes);
        $this->bind_manager->unbind($taxable_incomes);

        return $tax_results;
    }

    public function getStateIncomeClass(string $class, $user, Carbon $date = null)
    {
        app()->instance(Payroll::class, new Payroll([
            'start_date' => $date ?? Carbon::now(),
            'user' => $user,
        ], $this->wage_manager, $this->tax_manager));

        try {
            $class = app($class);
        } catch (Exception $e) {
            $class = null;
        }

        app()->forgetInstance(Payroll::class);
        return $class;
    }
}
