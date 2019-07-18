<?php
namespace Appleton\Taxes\Countries\US\Kentucky\HighlandHeightsCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\HighlandHeightsCity\HighlandHeightsCity as BaseHighlandHeightsCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class HighlandHeightsCity extends BaseHighlandHeightsCity
{
    use HasWageBase;

    public const TAX_RATE = 0.01;
    const WAGE_BASE = 100000;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
