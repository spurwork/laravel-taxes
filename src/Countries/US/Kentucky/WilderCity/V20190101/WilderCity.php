<?php
namespace Appleton\Taxes\Countries\US\Kentucky\WilderCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\WilderCity\WilderCity as BaseWilderCity;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class WilderCity extends BaseWilderCity
{
    use HasWageBase;

    public const TAX_RATE = 0.0225;
    const WAGE_BASE = 132900;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
