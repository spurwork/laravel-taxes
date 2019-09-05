<?php

namespace Appleton\Taxes\Countries\US\Kentucky\HazardCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\HazardCity\HazardCity as BaseHazardCity;
use Appleton\Taxes\Traits\HasBrackets;
use Illuminate\Database\Eloquent\Collection;

class HazardCity extends BaseHazardCity
{
    use HasBrackets;

    private const BRACKETS = [
        [0, 60000, 0.0125],
        [60000, null, 0.005],
    ];

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax($this->getTaxAmountFromBrackets($tax_areas->first()->workGovernmentalUnitArea)), 2);
    }
}
