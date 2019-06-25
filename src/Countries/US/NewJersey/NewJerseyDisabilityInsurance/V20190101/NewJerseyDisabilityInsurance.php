<?php


namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\V20190101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\NewJerseyDisabilityInsurance
    as BaseNewJerseyDisabilityInsurance;
use Illuminate\Database\Eloquent\Collection;

class NewJerseyDisabilityInsurance extends BaseNewJerseyDisabilityInsurance
{
    const WAGE_BASE = 34400;
    const TAX_RATE = 0.005;

    public function compute(Collection $tax_areas)
    {
        return round($this->getAdjustedEarnings() * self::TAX_RATE, 2);
    }

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }
}