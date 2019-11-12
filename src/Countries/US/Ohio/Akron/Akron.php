<?php

namespace Appleton\Taxes\Countries\US\Ohio\Akron;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseOccupational;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

abstract class Akron extends BaseOccupational
{
    public function doesApply(Collection $tax_areas): bool
    {
        return $this->payroll->birth_date === null
            || $this->payroll->birth_date->diffInYears(Carbon::now()->endOfYear()) >= 18;
    }
}
