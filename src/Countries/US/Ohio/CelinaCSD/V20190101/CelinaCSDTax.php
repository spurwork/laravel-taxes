<?php

namespace Appleton\Taxes\Countries\US\Ohio\CelinaCSDTax\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CelinaCSDTax\CelinaCSDTax as BaseCelinaCSDTax;
use Illuminate\Database\Eloquent\Collection;

class CelinaCSDTax extends BaseCelinaCSDTax
{
    public const TAX_RATE = 0.0075;
    const ID = '5401';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * $this->tax_rate, 2);
    }
}
