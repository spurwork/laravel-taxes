<?php

namespace Appleton\Taxes\Countries\US\Ohio\TeaysValleyLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TeaysValleyLSD\TeaysValleyLSDTax as BaseTeaysValleyLSDTax;
use Illuminate\Database\Eloquent\Collection;

class TeaysValleyLSDTax extends BaseTeaysValleyLSDTax
{
    public const TAX_RATE = 0.015;
    const ID = '6503';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}
