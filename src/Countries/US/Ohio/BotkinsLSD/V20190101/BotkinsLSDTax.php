<?php

namespace Appleton\Taxes\Countries\US\Ohio\BotkinsLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BotkinsLSD\BotkinsLSDTax as BaseBotkinsLSDTax;
use Illuminate\Database\Eloquent\Collection;

class BotkinsLSDTax extends BaseBotkinsLSDTax
{
    public const TAX_RATE = 0.0125;
    const ID = '7502';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}
