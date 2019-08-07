<?php

namespace Appleton\Taxes\Countries\US\Ohio\HopewellLoudonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HopewellLoudonLSD\HopewellLoudonLSDTax as BaseHopewellLoudonLSDTax;
use Illuminate\Database\Eloquent\Collection;

class HopewellLoudonLSDTax extends BaseHopewellLoudonLSDTax
{
    public const TAX_RATE = 0.005;
    const ID = '7403';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * self::TAX_RATE, 2);
    }
}
