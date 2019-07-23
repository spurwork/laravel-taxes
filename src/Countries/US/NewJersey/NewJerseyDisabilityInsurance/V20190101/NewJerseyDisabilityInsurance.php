<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\V20190101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\NewJerseyDisabilityInsurance as BaseNewJerseyDisabilityInsurance;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class NewJerseyDisabilityInsurance extends BaseNewJerseyDisabilityInsurance
{
    use HasWageBase;

    const TAX_RATE = 0.0017;
    const WAGE_BASE = 34400;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarningsWageBase($tax_areas->first()->workGovernmentalUnitArea) * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
