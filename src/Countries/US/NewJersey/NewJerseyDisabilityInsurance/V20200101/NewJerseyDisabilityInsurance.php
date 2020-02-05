<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\V20200101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\NewJerseyDisabilityInsurance as BaseNewJerseyDisabilityInsurance;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class NewJerseyDisabilityInsurance extends BaseNewJerseyDisabilityInsurance
{
    use HasWageBase;

    const TAX_RATE = 0.0026;
    const WAGE_BASE = 134900;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    }
}
