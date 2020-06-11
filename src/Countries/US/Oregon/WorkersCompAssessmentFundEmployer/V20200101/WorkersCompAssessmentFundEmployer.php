<?php

namespace Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFundEmployer\V20200101;

use Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFundEmployer\WorkersCompAssessmentFundEmployer as BaseWorkersCompAssessmentFundEmployer;
use Illuminate\Database\Eloquent\Collection;

class WorkersCompAssessmentFundEmployer extends BaseWorkersCompAssessmentFundEmployer
{
    const HOURLY_RATE_MODIFIER = .011;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getHoursWorked($tax_areas->first()->workGovernmentalUnitArea) * static::HOURLY_RATE_MODIFIER);

        return round($this->tax_total, 2);
    }
}
