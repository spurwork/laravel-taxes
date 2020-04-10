<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;
use Appleton\Taxes\Models\Tax;
use Illuminate\Support\Collection;

class TaxOverrideManager
{
    private $query_runner;

    public function __construct(TaxesQueryRunner $query_runner)
    {
        $this->query_runner = $query_runner;
    }

    /**
     * SUTA state unemployment replaces all state unemployment taxes with the
     * unemployment tax from the SUTA state. All wages are applicable to the
     * SUTA state unemployment tax.
     */
    public function replaceSutaUnemploymentTaxes(
        GeoPoint $suta_location,
        Collection &$taxable_incomes,
        Collection $wages,
        Collection $annual_wages): void
    {
        $taxable_incomes = $taxable_incomes->reject(static function (TaxableIncome $taxable_income) {
            return is_subclass_of($taxable_income->getTax()->class, BaseStateUnemployment::class);
        });

        $state_unemployment_taxes = $this->query_runner->lookupStateUnemploymentTaxes($suta_location);
        $state_unemployment_taxes->each(static function (Tax $tax) use ($taxable_incomes, $wages, $annual_wages) {
            $new_taxable_income = new TaxableIncome($tax, $wages, $annual_wages, 0);
            $taxable_incomes->put($tax->class, $new_taxable_income);
        });
    }

    /**
     * State income is based on federal wages but we only calculate for
     * wages earned in the state. If a worker works in a different state than they live
     * those withholdings get credited when they file at the end of the year.
     * We want to make sure that they are getting something withheld if they work
     * in a state without a state income so they have deductions to get credit for
     * at the end of the year.
     *
     * If there is no state income tax add the state income tax for the workers
     * home state if there is one. If the state income tax is added all wages
     * are applicable for the tax.
     */
    public function addStateIncomeTax(
        GeoPoint $home_location,
        Collection $taxable_income,
        Collection $wages,
        Collection $annual_wages): void
    {
        $has_state_income_tax = $taxable_income->filter(static function (TaxableIncome $taxable_wages) {
            return is_subclass_of($taxable_wages->getTax()->class, BaseStateIncome::class);
        })->isNotEmpty();

        if (!$has_state_income_tax) {
            $state_income_tax = $this->query_runner->lookupStateIncomeTaxByLocation($home_location);

            if ($state_income_tax !== null) {
                $new_taxable_income = new TaxableIncome(
                    $state_income_tax,
                    $wages,
                    $annual_wages,
                    0);
                $taxable_income->put($state_income_tax->class, $new_taxable_income);
            }
        }
    }

    /**
     * Reciprocal agreements take the state income tax from the work state and replace
     * it with the state income tax for the home state. All the wages from the work state
     * are applicable to the home state income tax.
     */
    public function processReciprocalAgreements(
        Collection $reciprocal_agreements,
        Collection $taxable_incomes): void
    {
        $reciprocal_agreements->each(function (ReciprocalAgreement $reciprocal_agreement) use ($taxable_incomes) {
            $work_state_income = $this->query_runner->lookupStateIncomeTaxByName($reciprocal_agreement->getWorkState());
            if ($work_state_income === null) {
                return;
            }

            /** @var TaxableIncome $work_state_income_taxable_income */
            $work_state_income_taxable_income = $taxable_incomes
                ->first(static function (TaxableIncome $taxable_wages) use ($work_state_income) {
                    return $taxable_wages->getTax()->class === $work_state_income->class;
                });

            if ($work_state_income_taxable_income === null) {
                return;
            }

            $home_state_income = $this->query_runner->lookupStateIncomeTaxByName($reciprocal_agreement->getHomeState());
            if ($home_state_income === null) {
                return;
            }


            if ($taxable_incomes->has($home_state_income->class)) {
                /** @var TaxableIncome $taxable_income */
                $taxable_income = $taxable_incomes->get($home_state_income->class);

                $new_wages = $taxable_income->getWages()->concat($work_state_income_taxable_income->getWages());
                $new_annual_wages = $taxable_income->getAnnualWages()->concat($work_state_income_taxable_income->getAnnualWages());
            } else {
                $new_wages = $work_state_income_taxable_income->getWages();
                $new_annual_wages = $work_state_income_taxable_income->getAnnualWages();
            }

            $new_taxable_income = new TaxableIncome(
                $home_state_income,
                $new_wages,
                $new_annual_wages,
                0
            );
            $taxable_incomes->put($home_state_income->class, $new_taxable_income);

            $taxable_incomes->forget($work_state_income->class);
        });
    }

    public function removeDisabledTaxes(Collection $disabled_taxes, Collection $taxable_incomes): void
    {
        $disabled_taxes->each(static function (string $tax_class) use ($taxable_incomes) {
            if ($taxable_incomes->has($tax_class)) {
                $taxable_incomes->forget($tax_class);
            }
        });
    }
}
