<?php

namespace Appleton\Taxes\Countries\US\Oregon\TrimetEmployer\V20200701;

use Appleton\Taxes\Countries\US\Oregon\TrimetEmployer\TrimetEmployer as BaseTrimetEmployer;
use Illuminate\Database\Eloquent\Collection;

class TrimetEmployer extends BaseTrimetEmployer
{
    const TAX_RATE = 0.007737;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->getEarnings() * self::TAX_RATE;
        return round($this->tax_total, 2);
    }
}
