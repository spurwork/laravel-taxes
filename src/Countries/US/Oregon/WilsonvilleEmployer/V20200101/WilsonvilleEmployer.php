<?php

namespace Appleton\Taxes\Countries\US\Oregon\WilsonvilleEmployer\V20200101;

use Appleton\Taxes\Countries\US\Oregon\WilsonvilleEmployer\WilsonvilleEmployer as BaseWilsonvilleEmployer;
use Illuminate\Database\Eloquent\Collection;

class WilsonvilleEmployer extends BaseWilsonvilleEmployer
{
    const TAX_RATE = 0.005;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->getEarnings() * self::TAX_RATE;
        return round($this->tax_total, 2);
    }
}
