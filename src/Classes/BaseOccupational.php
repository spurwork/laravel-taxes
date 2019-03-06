<?php

namespace Appleton\Taxes\Classes;

use Illuminate\Database\Eloquent\Collection;

abstract class BaseOccupational extends BaseLocal
{
    const WITHHELD = true;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
