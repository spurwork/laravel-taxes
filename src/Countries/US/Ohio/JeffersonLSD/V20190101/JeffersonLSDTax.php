<?php

namespace Appleton\Taxes\Countries\US\Ohio\JeffersonLSDTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\JeffersonLSDTax\JeffersonLSDTax as BaseJeffersonLSDTax;
use Illuminate\Database\Eloquent\Collection;

class JeffersonLSDTax extends BaseJeffersonLSDTax
{
    public const TAX_RATE = 0.01;
    const ID = '4901';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}