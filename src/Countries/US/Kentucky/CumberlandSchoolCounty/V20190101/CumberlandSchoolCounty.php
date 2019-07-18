<?php
namespace Appleton\Taxes\Countries\US\Kentucky\CumberlandSchoolCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CumberlandSchoolCounty\CumberlandSchoolCounty as BaseCumberlandSchoolCounty;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class CumberlandSchoolCounty extends BaseCumberlandSchoolCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.005;
    const WAGE_BASE = 100000;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
