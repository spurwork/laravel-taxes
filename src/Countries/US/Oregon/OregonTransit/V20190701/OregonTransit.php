<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonTransit\V20190701;

use Appleton\Taxes\Countries\US\Oregon\OregonTransit\OregonTransit as BaseOregonTransit;
use Illuminate\Database\Eloquent\Collection;

class OregonTransit extends BaseOregonTransit
{
    const TAX_RATE = 0.001;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax($this->getEarnings() * self::TAX_RATE), 2);
    }
}
