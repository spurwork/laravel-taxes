<?php

namespace Appleton\Taxes\Countries\US\Ohio\Columbus;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseOccupational;
use Illuminate\Database\Eloquent\Collection;

abstract class Columbus extends BaseOccupational
{
    public function doesApply(Collection $tax_areas): bool
    {
        return $this->payroll->birth_date === null || $this->payroll->birth_date->age >= 18;
    }
}
