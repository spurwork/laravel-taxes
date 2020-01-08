<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Models\Tax;
use Illuminate\Support\Collection;

class TaxableIncomeManager
{
    private $query_runner;

    public function __construct(TaxesQueryRunner $query_runner)
    {
        $this->query_runner = $query_runner;
    }

    public function groupWagesByTax(
        GeoPoint $home_location,
        Collection $wages_by_lat_long,
        Collection $historical_wages_by_lat_long): Collection
    {
        $taxable_incomes = collect([]);

        $wages_by_lat_long->each(function (Collection $wages, string $location) use ($taxable_incomes, $home_location) {
            $location_array = explode(',', $location);
            $work_location = new GeoPoint($location_array[0], $location_array[1]);

            $taxes = $this->query_runner->lookupTaxes($home_location, $work_location);
            $taxes->each(function (Tax $tax) use ($taxable_incomes, $wages) {
                $this->addWages($taxable_incomes, $tax, $wages, collect([]));
            });

            $wages->each(function (Wage $wage) use ($taxable_incomes) {
                $wage->getAdditionalTaxes()->each(function (string $additional_tax) use ($taxable_incomes, $wage) {
                    $tax = $this->query_runner->lookupTax($additional_tax);
                    $this->addWages($taxable_incomes, $tax, collect([$wage]), collect([]));
                });
            });
        });

        $historical_wages_by_lat_long->each(function (Collection $historical_wages, string $location) use ($taxable_incomes, $home_location) {
            $location_array = explode(',', $location);
            $work_location = new GeoPoint($location_array[0], $location_array[1]);

            $taxes = $this->query_runner->lookupTaxes($home_location, $work_location);
            $taxes->each(function (Tax $tax) use ($taxable_incomes, $historical_wages) {
                $this->addWages($taxable_incomes, $tax, collect([]), $historical_wages);
            });

            $historical_wages->each(function (Wage $wage) use ($taxable_incomes) {
                $wage->getAdditionalTaxes()->each(function (string $additional_tax) use ($taxable_incomes, $wage) {
                    $tax = $this->query_runner->lookupTax($additional_tax);
                    $this->addWages($taxable_incomes, $tax, collect([]), collect([$wage]));
                });
            });
        });

        $filtered_taxable_incomes = collect([]);
        $taxable_incomes->each(static function (TaxableIncome $taxable_income) use ($filtered_taxable_incomes) {
            if (app($taxable_income->getTax()->class)->doesApply($taxable_income->getTax()->taxAreas)) {
                $filtered_taxable_incomes->put($taxable_income->getTax()->class, $taxable_income);
            }
        });

        return $filtered_taxable_incomes;
    }

    public function processExemptions(Collection $taxable_incomes, Collection $exemptions): void
    {
        $taxable_incomes->each(static function (TaxableIncome $taxable_income) use ($exemptions, $taxable_incomes) {
            $applicable_exemptions = $exemptions->filter(static function (float $amount, string $tax_class) use ($taxable_income) {
                $class = $taxable_income->getTax()->class;
                return $class === $tax_class || is_subclass_of($class, $tax_class);
            });

            if ($applicable_exemptions->isEmpty()) {
                return;
            }

            $exemption_amount = $exemptions->first();
            if ($exemption_amount > 0) {
                $new_taxable_income = new TaxableIncome(
                    $taxable_income->getTax(),
                    $taxable_income->getWages(),
                    $taxable_income->getHistoricalWages(),
                    bcmul($exemption_amount, 100)
                );

                $taxable_incomes->put($taxable_income->getTax()->class, $new_taxable_income);
            }
        });
    }

    private function addWages(
        Collection $taxable_incomes,
        Tax $tax,
        Collection $wages,
        Collection $historical_wages): void
    {
        if (!$taxable_incomes->has($tax->class)) {
            $empty_taxable_income = new TaxableIncome($tax, collect([]), collect([]), 0);
            $taxable_incomes->put($tax->class, $empty_taxable_income);
        }

        /** @var TaxableIncome $taxable_income */
        $taxable_income = $taxable_incomes->get($tax->class);

        $new_taxable_income = new TaxableIncome(
            $tax,
            $taxable_income->getWages()->concat($wages),
            $taxable_income->getHistoricalWages()->concat($historical_wages),
            0);

        $taxable_incomes->put($tax->class, $new_taxable_income);
    }
}
