<?php

namespace Appleton\Taxes\Countries\US\Ohio\GibsonburgEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\GibsonburgEVSD\GibsonburgEVSDTax as BaseGibsonburgEVSDTax;
use Illuminate\Database\Eloquent\Collection;

class GibsonburgEVSDTax extends BaseGibsonburgEVSDTax
{
    public const TAX_RATE = 0.0075;
    const ID = '7203';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * self::TAX_RATE, 2);
    }
}
