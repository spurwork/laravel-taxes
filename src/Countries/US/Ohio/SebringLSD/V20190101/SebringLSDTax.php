<?php

namespace Appleton\Taxes\Countries\US\Ohio\SebringLSDTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SebringLSDTax\SebringLSDTax as BaseSebringLSDTax;
use Illuminate\Database\Eloquent\Collection;

class SebringLSDTax extends BaseSebringLSDTax
{
    public const TAX_RATE = 0.01;
    const ID = '5008';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}