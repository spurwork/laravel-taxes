<?php

namespace Appleton\Taxes\Countries\US\Ohio\Columbus\V20190101;

use Appleton\Taxes\Countries\US\Ohio\Columbus\Columbus as BaseColumbus;
use Illuminate\Database\Eloquent\Collection;

class Columbus extends BaseColumbus
{
    public const TAX_RATE = 0.025;

    public function compute(Collection $tax_areas)
    {
        if ($this->payroll->birth_date->age >= 18) {
            $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);
            return round($this->tax_total, 2);
        }

        return 0.0;
    }
}
