<?php
namespace Appleton\Taxes\Countries\US\Kentucky\RussellCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\RussellCounty\RussellCounty as BaseRussellCounty;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class RussellCounty extends BaseRussellCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.0075;
    const WAGE_BASE = 33333.33;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    }
}
