<?php

namespace Appleton\Taxes\Countries\US\Ohio\BerneUnionLSDTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BerneUnionLSDTax\BerneUnionLSDTax as BaseBerneUnionLSDTax;
use Illuminate\Database\Eloquent\Collection;

class BerneUnionLSDTax extends BaseBerneUnionLSDTax
{
    public const TAX_RATE = 0.02;
    const ID = '2302';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}
