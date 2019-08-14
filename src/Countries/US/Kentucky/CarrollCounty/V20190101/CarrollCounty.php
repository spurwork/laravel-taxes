<?php

namespace Appleton\Taxes\Countries\US\Kentucky\CarrollCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CarrollCounty\CarrollCounty as BaseCarrollCounty;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class CarrollCounty extends BaseCarrollCounty
{
    use HasWageBase;

    public const TAX_RATE = 0.01;
    const WAGE_START = 5000;
    const WAGE_BASE = 50000;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    }
}
