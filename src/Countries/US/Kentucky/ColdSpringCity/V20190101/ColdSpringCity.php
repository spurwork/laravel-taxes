<?php
namespace Appleton\Taxes\Countries\US\Kentucky\ColdSpringCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\ColdSpringCity\ColdSpringCity as BaseColdSpringCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class ColdSpringCity extends BaseColdSpringCity
{
    use HasWageBase;

    public const TAX_RATE = 0.01;
    const WAGE_BASE = 132900;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
