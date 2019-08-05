<?php

namespace Appleton\Taxes\Countries\US\Ohio\NortheasternLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NortheasternLSD\NortheasternLSDTax as BaseNortheasternLSDTax;
use Illuminate\Database\Eloquent\Collection;

class NortheasternLSDTax extends BaseNortheasternLSDTax
{
    public const TAX_RATE = 0.01;
    const ID = '1203';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * self::TAX_RATE, 2);
    }
}
