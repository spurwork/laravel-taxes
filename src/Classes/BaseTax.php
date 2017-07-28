<?php

namespace Appleton\Taxes\Classes;

abstract class BaseTax
{
    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    public function compute()
    {
        return round($this->payroll->earnings * static::TAX_RATE, 2);
    }
}
