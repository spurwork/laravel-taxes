<?php

namespace Appleton\Taxes\Countries\US\Ohio\TroyCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TroyCSD\TroyCSDTax as BaseTroyCSDTax;
use Illuminate\Database\Eloquent\Collection;

class TroyCSDTax extends BaseTroyCSDTax
{
    public const TAX_RATE = 0.015;
    const ID = '5509';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * self::TAX_RATE, 2);
    }
}
