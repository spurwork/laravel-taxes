<?php

namespace Appleton\Taxes\Classes;

class BaseTax
{
    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
        if (defined('static::TAX_INFORMATION')) {
            if (is_null($this->payroll->user)) {
                $this->tax_information = (static::TAX_INFORMATION)::getDefault($this->payroll->date);
            } else {
                $this->tax_information = (static::TAX_INFORMATION)::forUser($this->payroll->user)->first();
                if (is_null($this->tax_information)) {
                    throw new \Exception('The tax information for that user could not be loaded.');
                }
            }
        }
    }

    public function compute()
    {
        return round($this->payroll->earnings * static::TAX_RATE, 2);
    }
}
