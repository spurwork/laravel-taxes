<?php

namespace Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFund\V20200101;

use Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFund\WorkersCompAssessmentFund as BaseWorkersCompAssessmentFund;

use Illuminate\Database\Eloquent\Collection;

class WorkersCompAssessmentFund extends BaseWorkersCompAssessmentFund
{
    const HOURLY_RATE_MODIFIER = 0.011;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getHoursWorked($tax_areas->first()->workGovernmentalUnitArea) * static::HOURLY_RATE_MODIFIER);

        return round($this->tax_total, 2);
    }
}
