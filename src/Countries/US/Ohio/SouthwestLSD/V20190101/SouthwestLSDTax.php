<?php

namespace Appleton\Taxes\Countries\US\Ohio\SouthwestLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SouthwestLSD\SouthwestLSDTax as BaseSouthwestLSDTax;
use Illuminate\Database\Eloquent\Collection;

class SouthwestLSDTax extends BaseSouthwestLSDTax
{
    public const TAX_RATE = 0.0075;
    const ID = '3118';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * self::TAX_RATE, 2);
    }
}
