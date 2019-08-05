<?php

namespace Appleton\Taxes\Countries\US\Ohio\BerkshireLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BerkshireLSD\BerkshireLSDTax as BaseBerkshireLSDTax;
use Illuminate\Database\Eloquent\Collection;

class BerkshireLSDTax extends BaseBerkshireLSDTax
{
    public const TAX_RATE = 0.01;
    const ID = '2801';

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt || $this->tax_information->school_district_id !== self::ID) {
            return 0.0;
        }

        return round($this->payroll->getEarnings() * self::TAX_RATE, 2);
    }
}
