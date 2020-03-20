<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareTrainingTaxEmployer\V20200101;

use Appleton\Taxes\Countries\US\Delaware\DelawareTrainingTaxEmployer\DelawareTrainingTaxEmployer as BaseDelawareTrainingTaxEmployer;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class DelawareTrainingTaxEmployer extends BaseDelawareTrainingTaxEmployer
{
    use HasWageBase;

    const TAX_RATE = 0.00095;
    const WAGE_BASE = 16500;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings(), $this->getBaseEarnings($tax_areas->first()->workGovernmentalUnitArea)) * self::TAX_RATE), 2);
    }
}
