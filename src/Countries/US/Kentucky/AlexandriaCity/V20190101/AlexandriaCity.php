<?php
namespace Appleton\Taxes\Countries\US\Kentucky\AlexandriaCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\AlexandriaCity\AlexandriaCity as BaseAlexandriaCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class AlexandriaCity extends BaseAlexandriaCity
{
    use HasWageBase;

    public const TAX_RATE = 0.015;
    const WAGE_BASE = 132900;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
