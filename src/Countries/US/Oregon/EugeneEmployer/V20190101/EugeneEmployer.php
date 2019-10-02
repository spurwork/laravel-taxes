<?php

// namespace Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\V20190101;

// use Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\EugeneEmployer as BaseEugeneEmployer;
// use Illuminate\Database\Eloquent\Collection;

// class EugeneEmployer extends BaseEugeneEmployer
// {
//     public function compute(Collection $tax_areas)
//     {
//         dump('herer2');
//         return 0.0;
//     }
// }

namespace Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\V20190101;

use Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\EugeneEmployer as BaseEugeneEmployer;
use Illuminate\Database\Eloquent\Collection;

class EugeneEmployer extends BaseEugeneEmployer
{
    const TAX_RATE = 0.0021;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->getAdjustedEarnings() * self::TAX_RATE;
        return round($this->tax_total, 2);
    }

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }
}
