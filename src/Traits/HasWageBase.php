<?php

namespace Appleton\Taxes\Traits;

use Illuminate\Database\Eloquent\Collection;

trait HasWageBase
{
    public function compute(Collection $tax_areas)
    {
        $taxable_earnings = $this->calculateTaxableEarnings($this->getTaxClass());
        $this->tax_total = min($this->payroll->getEarnings(), $taxable_earnings) * $this->getTaxRate();

        if (static::WITHHELD) {
            return round($this->payroll->withholdTax($this->tax_total), 2);
        }

        return round($this->tax_total, 2);
    }

    public function calculateRoundedToDollar(): int
    {
        $taxable_earnings = $this->calculateTaxableEarnings($this->getTaxClass());
        $tax_amount = min($this->payroll->getEarnings(), $taxable_earnings) * $this->getTaxRate();

        return round($tax_amount * 100, -2) / 100;
    }

    public function getEarnings()
    {
        return $this->calculateTaxableEarnings($this->getTaxClass());
    }

    protected function getTaxClass(): string
    {
        return get_parent_class($this);
    }

    protected function getTaxRate(): float
    {
        return static::TAX_RATE;
    }

    protected function calculateTaxableEarnings(string $tax_class)
    {
        $ytd_taxable_wages = $this->payroll->getYtdTaxableWages($tax_class);
        $taxable_earnings = static::WAGE_BASE - $ytd_taxable_wages;
        return max(min($taxable_earnings, $this->payroll->getEarnings()), 0);
    }
}
