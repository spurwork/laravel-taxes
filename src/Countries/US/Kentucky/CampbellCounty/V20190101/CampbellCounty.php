<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CampbellCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CampbellCounty\CampbellCounty as BaseCampbellCounty;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class CampbellCounty extends BaseCampbellCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.0105;
    const WAGE_BASE = 38667;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
