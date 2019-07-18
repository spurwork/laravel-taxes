<?php

namespace Appleton\Taxes\Countries\US\Kentucky\BrooksvilleCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\BrooksvilleCity\BrooksvilleCity as BaseBrooksvilleCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class BrooksvilleCity extends BaseBrooksvilleCity
{
    use HasWageBase;

    public const TAX_RATE = 0.0175;
    const WAGE_BASE = 51428.58;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
