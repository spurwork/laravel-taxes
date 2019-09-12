<?php

namespace Appleton\Taxes\Countries\US\Kentucky\CarrollCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CarrollCounty\CarrollCounty as BaseCarrollCounty;
use Appleton\Taxes\Traits\HasBrackets;
use Illuminate\Database\Eloquent\Collection;

class CarrollCounty extends BaseCarrollCounty
{
    use HasBrackets;

    private const BRACKETS = [
        [0, 5000, 0.0],
        [5000, 50000, 0.01],
        [50000, null, 0.0],
    ];

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax($this->getTaxAmountFromBrackets($tax_areas->first()->workGovernmentalUnitArea)), 2);
    }
}
