<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

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
        Collection $taxable_incomes): Collection
    {
        return $this->tax_sorter->sort($taxable_incomes)
            ->mapWithKeys(static function (TaxableIncome $taxable_income) use ($payroll) {
                $payroll->determineEarnings($taxable_income);

                $tax_implementation = app($taxable_income->getTax()->class);

                $amount_in_cents = bcmul($tax_implementation->compute($taxable_income->getTax()->taxAreas), 100);

                $tax_result = new TaxResult(
                    $taxable_income->getTax()->class,
                    $taxable_income->getTax()->name,
                    $tax_implementation,
                    $amount_in_cents,
                    bcmul($payroll->getEarnings(), 100));

                app()->instance($taxable_income->getTax()->class, $tax_implementation);

                return [$taxable_income->getTax()->class => $tax_result];
            })->filter(static function (TaxResult $tax_result) {
                return $tax_result->getAmountInCents() > 0;
            });
    }
}
