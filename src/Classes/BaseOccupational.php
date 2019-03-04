<?php

namespace Appleton\Taxes\Classes;

abstract class BaseOccupational extends BaseTax
{
    const TYPE = 'local';
    const WITHHELD = true;

    public function compute()
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
