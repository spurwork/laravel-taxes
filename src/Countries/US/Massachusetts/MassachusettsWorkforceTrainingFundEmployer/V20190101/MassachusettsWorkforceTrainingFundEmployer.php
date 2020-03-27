<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsWorkforceTrainingFundEmployer\V20190101;

use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsWorkforceTrainingFundEmployer\MassachusettsWorkforceTrainingFundEmployer as BaseMassachusettsWorkforceTrainingFundEmployer;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class MassachusettsWorkforceTrainingFundEmployer extends BaseMassachusettsWorkforceTrainingFundEmployer
{
    use HasWageBase;

    const WAGE_BASE = 15000;
    const TAX_RATE = 0.00056;

    public function compute(Collection $tax_areas)
    {
        return round($this->getAdjustedEarnings() * self::TAX_RATE, 2);
    }

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }
}
