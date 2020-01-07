<?php

namespace Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFund\V20190101;

use Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFund\WorkersCompAssessmentFund as BaseWorkersCompAssessmentFund;
use Illuminate\Database\Eloquent\Collection;

class WorkersCompAssessmentFund extends BaseWorkersCompAssessmentFund
{
    public function compute(Collection $tax_areas)
    {
        return 0.0;
    }
}
