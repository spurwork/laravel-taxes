<?php

namespace Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandDisabilityInsurance\V20200101;

use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandDisabilityInsurance\RhodeIslandDisabilityInsurance as BaseRhodeIslandDisabilityInsurance;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class RhodeIslandDisabilityInsurance extends BaseRhodeIslandDisabilityInsurance
{
    use HasWageBase;

    const TAX_RATE = 0.013;
    const WAGE_BASE = 72300;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    }
}
