<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareEmployerTrainingTax\V20200101;

use Appleton\Taxes\Countries\US\Delaware\DelawareEmployerTrainingTax\DelawareEmployerTrainingTax as BaseDelawareEmployerTrainingTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class DelawareEmployerTrainingTax extends BaseDelawareEmployerTrainingTax
{
    use HasWageBase;

    const TAX_RATE = 0.00095;
    const WAGE_BASE = 16500;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    }
}
