<?php

namespace Appleton\Taxes\Countries\US\Oregon\CanbyEmployer\V20200101;

use Appleton\Taxes\Countries\US\Oregon\CanbyEmployer\CanbyEmployer as BaseCanbyEmployer;
use Illuminate\Database\Eloquent\Collection;

class CanbyEmployer extends BaseCanbyEmployer
{
    const TAX_RATE = 0.006;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * self::TAX_RATE);

        return round($this->tax_total, 2);
    }
}
