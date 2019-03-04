<?php

namespace Appleton\Taxes\Classes;

abstract class BaseTax
{
    const PRIORITY = 9999;

    public $tax_total = 0;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll->exemptEarnings(get_parent_class($this));
    }

    public function compute()
    {
        $this->tax_total = $this->payroll->getEarnings() * static::TAX_RATE;
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
}
