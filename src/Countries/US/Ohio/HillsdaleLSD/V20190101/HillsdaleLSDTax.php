<?php

namespace Appleton\Taxes\Countries\US\Ohio\HillsdaleLSDTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HillsdaleLSDTax\HillsdaleLSDTax as BaseHillsdaleLSDTax;
use Illuminate\Database\Eloquent\Collection;

class HillsdaleLSDTax extends BaseHillsdaleLSDTax
{
    public const TAX_RATE = 0.0125;
    const ID = '0302';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}
