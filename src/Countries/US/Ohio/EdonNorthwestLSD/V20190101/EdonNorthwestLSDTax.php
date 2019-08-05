<?php

namespace Appleton\Taxes\Countries\US\Ohio\EdonNorthwestLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\EdonNorthwestLSD\EdonNorthwestLSDTax as BaseEdonNorthwestLSDTax;
use Illuminate\Database\Eloquent\Collection;

class EdonNorthwestLSDTax extends BaseEdonNorthwestLSDTax
{
    public const TAX_RATE = 0.01;
    const ID = '8603';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * self::TAX_RATE, 2);
    }
}
