<?php

namespace Appleton\Taxes\Countries\US\Ohio\MiamiEastLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MiamiEastLSD\MiamiEastLSDTax as BaseMiamiEastLSDTax;
use Illuminate\Database\Eloquent\Collection;

class MiamiEastLSDTax extends BaseMiamiEastLSDTax
{
    public const TAX_RATE = 0.0175;
    const ID = '5504';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * self::TAX_RATE, 2);
    }
}
