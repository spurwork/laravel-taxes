<?php

namespace Appleton\Taxes\Countries\US\Missouri\StLouisEmployer\V20200101;

use Appleton\Taxes\Countries\US\Missouri\StLouisEmployer\StLouisEmployer as BaseStLouisEmployer;
use Illuminate\Database\Eloquent\Collection;

class StLouisEmployer extends BaseStLouisEmployer
{
    const TAX_RATE = 0.001;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);

        return round($this->tax_total, 2);
    }
}
