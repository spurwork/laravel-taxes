<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;

/**
 * TODO:
 * unit tests
 * move files to WorkerTaxes
 * move tests to Unit
 * reciprocal agreements for local
 * rework tests to not change taxes during replaceSutaUnemploymentTaxes and addStateIncomeTax (check PennsylvaniaEmployeeSuta)
 *
 * Taxes changed:
 *  CO local taxes (OP taxes) changed, retest
 *  Maryland state income tax
 *  NewYorkDisabilityInsurance
 *  NewYorkFamilyMedicalLeave
 *  West Virginia city service fees
 *  Kentucky = Caneyville City - reworked how days worked is calculated, only gets days in the work week
 *      not sure how we want to account for shifts getting closed in a prior week
 *
 */
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
        BindManager $bind_manager)
    {
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
        GeoPoint $home_location,
        GeoPoint $suta_location,
        Collection $wages,
        Collection $historical_wages,
        $user,
        ?Carbon $birth_date,
        int $pay_periods,
        Collection $reciprocal_agreements,
        Collection $disabled_taxes,
        Collection $exemptions): Collection
    {
        $wages_by_lat_long = $this->wage_manager->groupLatLong($wages);
        $historical_wages_by_lat_long = $this->wage_manager->groupLatLong($historical_wages);

        $taxable_incomes = $this->taxable_income_manager->groupWagesByTax(
            $home_location,
            $wages_by_lat_long,
            $historical_wages_by_lat_long
        );

        $this->tax_override_manager->replaceSutaUnemploymentTaxes($suta_location, $taxable_incomes,
            $wages, $historical_wages);
        $this->tax_override_manager->addStateIncomeTax($home_location, $taxable_incomes,
            $wages, $historical_wages);
        $this->tax_override_manager->processReciprocalAgreements($reciprocal_agreements, $taxable_incomes);
        $this->tax_override_manager->removeDisabledTaxes($disabled_taxes, $taxable_incomes);

        $this->taxable_income_manager->processExemptions($taxable_incomes, $exemptions);

        $area_incomes = $this->area_income_manager
            ->groupWagesByGovernmentalArea($wages_by_lat_long, $historical_wages_by_lat_long);

        $payroll = new Payroll([
            'date' => $start_date,
            'user' => $user,
            'birth_date' => $birth_date,
            'pay_periods' => $pay_periods,
            'area_incomes' => $area_incomes,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_earnings' => $this->wage_manager->calculateEarnings($wages)
        ], $this->wage_manager);

        $this->bind_manager->bind($payroll, $taxable_incomes);
        $tax_results = $this->tax_manager->computeTaxes($payroll, $taxable_incomes);
        $this->bind_manager->unbind($taxable_incomes);

        return $tax_results;
    }

    public function getStateIncomeClass(string $class, $user, Carbon $date = null)
    {
        app()->instance(Payroll::class, new Payroll([
            'start_date' => $date ?? Carbon::now(),
            'user' => $user,
        ], $this->wage_manager));

        try {
            $class = app($class);
        } catch (Exception $e) {
            $class = null;
        }

        app()->forgetInstance(Payroll::class);
        return $class;
    }
}
