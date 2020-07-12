<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\LiabilityAmount;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TaxManager
{
    private $tax_sorter;

    public function __construct(TaxSorter $tax_sorter)
    {
        $this->tax_sorter = $tax_sorter;
    }

    public function computeTaxes(
        Payroll $payroll,
        Collection $taxable_incomes
    ): Collection {
        return $this->tax_sorter->sort($taxable_incomes)
            ->mapWithKeys(static function (TaxableIncome $taxable_income) use ($payroll) {
                $payroll->determineEarnings($taxable_income);

                $tax_implementation = app($taxable_income->getTax()->class);

                $val = $tax_implementation->compute($taxable_income->getTax()->taxAreas);
                if (! ($val instanceof Collection)) {
                    $amount_in_cents = bcmul($val, 100);
                    $earnings_in_cents = bcmul($tax_implementation->getEarnings(), 100);

                    $tax_result = new TaxResult(
                        $taxable_income->getTax()->class,
                        $taxable_income->getTax()->name,
                        $tax_implementation,
                        $amount_in_cents,
                        $earnings_in_cents
                    );

                    app()->instance($taxable_income->getTax()->class, $tax_implementation);

                    return [$taxable_income->getTax()->class => $tax_result];
                } else {
                    $tax_results = $val->map(function ($data) use ($tax_implementation, $taxable_income) {
                        $amount_in_cents = bcmul($data['amount'], 100);
                        $earnings_in_cents = bcmul($data['earnings'], 100);
                        return new TaxResult(
                            $taxable_income->getTax()->class,
                            $taxable_income->getTax()->name,
                            $tax_implementation,
                            $amount_in_cents,
                            $earnings_in_cents
                        );
                    });

                    app()->instance($taxable_income->getTax()->class, $tax_implementation);

                    return [$taxable_income->getTax()->class => $tax_results];
                }
            });
    }

    public function computeYtdTaxableWages(
        Collection $taxable_wages,
        string $tax_class,
        Carbon $date
    ): float {
        if (!$taxable_wages->has($tax_class)) {
            return 0.0;
        }

        $start_of_year = $date->copy()->startOfYear();

        return $taxable_wages
                ->get($tax_class)
                ->filter(static function (TaxableWage $taxable_wage) use ($start_of_year, $date) {
                    return $taxable_wage->getDate()->gte($start_of_year)
                        && $taxable_wage->getDate()->lte($date);
                })->sum(static function (TaxableWage $taxable_wage) {
                    return $taxable_wage->getAmount();
                }) / 100;
    }

    public function computeYtdLiabilities(
        Collection $liabilities,
        string $tax_class,
        Carbon $date
    ): float {
        if (!$liabilities->has($tax_class)) {
            return 0.0;
        }

        $start_of_year = $date->copy()->startOfYear();

        return $liabilities
                ->get($tax_class)
                ->filter(static function (LiabilityAmount $liability) use ($start_of_year, $date) {
                    return $liability->getDate()->gte($start_of_year)
                        && $liability->getDate()->lte($date);
                })->sum(static function (LiabilityAmount $liability) {
                    return $liability->getAmount();
                }) / 100;
    }

    public function computeMtdTaxableWages(
        Collection $taxable_wages,
        string $tax_class,
        Carbon $date
    ): float {
        if (!$taxable_wages->has($tax_class)) {
            return 0.0;
        }

        $start_date = $date->copy()->startOfMonth();

        return $taxable_wages
                ->get($tax_class)
                ->filter(static function (TaxableWage $taxable_wage) use ($start_date, $date) {
                    return $taxable_wage->getDate()->gte($start_date)
                        && $taxable_wage->getDate()->lte($date);
                })
                ->sum(static function (TaxableWage $taxable_wage) {
                    return $taxable_wage->getAmount();
                }) / 100;
    }
}
