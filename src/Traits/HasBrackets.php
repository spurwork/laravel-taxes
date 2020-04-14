<?php

namespace Appleton\Taxes\Traits;

trait HasBrackets
{
    private function calculateTaxForBracket($start, $stop, $rate, $earnings, $ytd_earnings)
    {
        $start = max($start, $ytd_earnings);

        $stop = min($stop ?? $start + $earnings, $earnings + $ytd_earnings);

        $earnings = min($earnings, max($stop - $start, 0));

        return $earnings * $rate;
    }

    public function getTaxAmountFromBrackets(string $tax_class)
    {
        $tax_amount = 0;
        $earnings = $this->payroll->getEarnings();
        $ytd_taxable_earnings = $this->payroll->getYtdTaxableWages($tax_class);

        foreach (self::BRACKETS as $index => [$start, $stop, $rate]) {
            $tax_amount += $this->calculateTaxForBracket($start, $stop, $rate, $earnings, $ytd_taxable_earnings);
        }

        return round($tax_amount, 2);
    }
}
