<?php

namespace Appleton\Taxes\Countries\US\Ohio\CloverleafLSDTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CloverleafLSDTax\CloverleafLSDTax as BaseCloverleafLSDTax;
use Illuminate\Database\Eloquent\Collection;

class CloverleafLSDTax extends BaseCloverleafLSDTax
{
    public const TAX_RATE = 0.0125;
    const ID = '5204';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}
