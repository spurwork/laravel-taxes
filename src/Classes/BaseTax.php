<?php

namespace Appleton\Taxes\Classes;

use Illuminate\Database\Eloquent\Collection;

abstract class BaseTax
{
    const PRIORITY = 9999;

    public $tax_total = 0;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll->exemptEarnings(get_parent_class($this));
    }

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }

    public function getAdjustedEarnings()
    {
        return $this->payroll->getEarnings();
    }

    public function getAmount()
    {
        return $this->tax_total;
    }

    public function getEarnings()
    {
        return method_exists($this, 'getBaseEarnings') ? $this->getBaseEarnings() : $this->payroll->getEarnings();
    }

    public function getBaseEarningsWageBase()
    {
        if (($this->payroll->earnings + $this->payroll->ytd_earnings + $this->payroll->wtd_earnings) < static::WAGE_BASE) {
            return max(min(static::WAGE_BASE - $this->payroll->ytd_earnings, $this->payroll->getEarnings()), 0);
        } elseif (($this->payroll->earnings + $this->payroll->ytd_earnings + $this->payroll->wtd_earnings) >= static::WAGE_BASE) {
            $total = static::WAGE_BASE - $this->payroll->ytd_earnings;

            return $total > 0 ? $total : 0;
        }

        return 0;
    }
}
