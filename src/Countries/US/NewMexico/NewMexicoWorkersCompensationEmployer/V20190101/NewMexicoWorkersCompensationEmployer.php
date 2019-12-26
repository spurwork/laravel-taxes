<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoWorkersCompensationEmployer\V20190101;

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoWorkersCompensationEmployer\NewMexicoWorkersCompensationEmployer as BaseNewMexicoWorkersCompensationEmployer;
use Illuminate\Database\Eloquent\Collection;

class NewMexicoWorkersCompensationEmployer extends BaseNewMexicoWorkersCompensationEmployer
{
    public function compute(Collection $tax_areas)
    {
        if ($this->payroll->getStartDate()->weekOfMonth === $this->payroll->getStartDate()->endOfQuarter()->weekOfMonth) {
            return 2.30;
        } else {
            return 0.00;
        }
    }
}
