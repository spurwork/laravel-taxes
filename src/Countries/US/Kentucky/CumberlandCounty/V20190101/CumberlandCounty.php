<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CumberlandCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CumberlandCounty\CumberlandCounty as BaseCumberlandCounty;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class CumberlandCounty extends BaseCumberlandCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.0125;
    const WAGE_BASE = 60000;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
