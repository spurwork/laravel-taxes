<?php

namespace Appleton\Taxes\Countries\US\Oregon\SandyEmployer\V20200101;

use Appleton\Taxes\Countries\US\Oregon\SandyEmployer\SandyEmployer as BaseSandyEmployer;
use Illuminate\Database\Eloquent\Collection;

class SandyEmployer extends BaseSandyEmployer
{
    const TAX_RATE = 0.006;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * self::TAX_RATE);

        return round($this->tax_total, 2);
    }
}
