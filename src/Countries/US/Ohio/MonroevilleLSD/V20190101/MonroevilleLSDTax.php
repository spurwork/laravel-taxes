<?php

namespace Appleton\Taxes\Countries\US\Ohio\MonroevilleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MonroevilleLSD\MonroevilleLSDTax as BaseMonroevilleLSDTax;
use Illuminate\Database\Eloquent\Collection;

class MonroevilleLSDTax extends BaseMonroevilleLSDTax
{
    public const TAX_RATE = 0.015;
    const ID = '3902';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}
