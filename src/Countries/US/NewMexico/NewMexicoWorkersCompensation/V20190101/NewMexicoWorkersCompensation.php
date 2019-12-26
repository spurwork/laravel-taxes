<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoWorkersCompensation\V20190101;

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoWorkersCompensation\NewMexicoWorkersCompensation as BaseNewMexicoWorkersCompensation;
use Illuminate\Database\Eloquent\Collection;

class NewMexicoWorkersCompensation extends BaseNewMexicoWorkersCompensation
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
