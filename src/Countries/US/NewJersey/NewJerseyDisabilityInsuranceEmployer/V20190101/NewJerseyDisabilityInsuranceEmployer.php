<?php


namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsuranceEmployer\V20190101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsuranceEmployer\NewJerseyDisabilityInsuranceEmployer as BaseNewJerseyDisabilityInsuranceEmployer;
use Illuminate\Database\Eloquent\Collection;

class NewJerseyDisabilityInsuranceEmployer extends BaseNewJerseyDisabilityInsuranceEmployer
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
