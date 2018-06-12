<?php

namespace Appleton\Taxes\Classes;

abstract class BaseTax
{
    public $tax_total = 0;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    public function compute()
    {
        $this->tax_total = $this->payroll->earnings * static::TAX_RATE;
        return round($this->tax_total, 2);
    }

    public function getAdjustedEarnings()
    {
        return $this->payroll->earnings;
    }

    public function getAmount()
    {
        return $this->tax_total;
    }
}
