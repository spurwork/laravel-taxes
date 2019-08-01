<?php

namespace Appleton\Taxes\Countries\US\Ohio\TriCountyNorthLSDTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TriCountyNorthLSDTax\TriCountyNorthLSDTax as BaseTriCountyNorthLSDTax;
use Illuminate\Database\Eloquent\Collection;

class TriCountyNorthLSDTax extends BaseTriCountyNorthLSDTax
{
    public const TAX_RATE = 0.01;
    const ID = '6806';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}
