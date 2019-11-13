<?php

namespace Appleton\Taxes\Countries\US\Kentucky\CaneyvilleCity;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseOccupational;
use Illuminate\Database\Eloquent\Collection;

abstract class CaneyvilleCity extends BaseOccupational
{
    public function doesApply(Collection $tax_areas): bool
    {
        $days_worked = $this->payroll->getDaysWorked(get_parent_class($this), $tax_areas->first()->workGovernmentalUnitArea);
        return $days_worked > 2;
    }
}
