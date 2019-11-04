<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkDisabilityInsurance\V20190101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkDisabilityInsurance\NewYorkDisabilityInsurance as BaseNewYorkDisabilityInsurance;
use Illuminate\Database\Eloquent\Collection;

class NewYorkDisabilityInsurance extends BaseNewYorkDisabilityInsurance
{
    const TAX_RATE = 0.005;
    const WAGE_BASE = 120;

    public function getBaseEarnings()
    {
        return min(self::WAGE_BASE, $this->payroll->getEarnings());
    }

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
