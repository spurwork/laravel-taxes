<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentonCounty\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\KentonCounty\KentonCounty as BaseKentonCounty;
use Appleton\Taxes\Traits\HasBrackets;
use Illuminate\Database\Eloquent\Collection;

class KentonCounty extends BaseKentonCounty
{
    use HasBrackets;

    private const BRACKETS = [
        [0, 25000, 0.007097],
        [25000, 132900, 0.001097],
    ];

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax($this->getTaxAmountFromBrackets(BaseKentonCounty::class)), 2);
    }
}
