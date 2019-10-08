<?php

namespace Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\V20190101;

use Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\EugeneEmployer as BaseEugeneEmployer;
use Illuminate\Database\Eloquent\Collection;

class EugeneEmployer extends BaseEugeneEmployer
{
    // public function compute(Collection $tax_areas)
    // {
    //     return 0.0;
    // }

    // this and below needs to be removed and the commented section above needs to uncommented

    const TAX_RATE = 0.0021;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->getEarnings() * self::TAX_RATE;
        return round($this->tax_total, 2);
    }
}
