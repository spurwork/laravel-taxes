<?php

namespace Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFundEmployer\V20190101;

use Appleton\Taxes\Countries\US\Oregon\WorkersCompAssessmentFundEmployer\WorkersCompAssessmentFundEmployer as BaseWorkersCompAssessmentFundEmployer;
use Illuminate\Database\Eloquent\Collection;

class WorkersCompAssessmentFundEmployer extends BaseWorkersCompAssessmentFundEmployer
{
    public function compute(Collection $tax_areas)
    {
        return 0.0;
    }
}
