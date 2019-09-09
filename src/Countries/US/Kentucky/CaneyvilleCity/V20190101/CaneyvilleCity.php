<?php

namespace Appleton\Taxes\Countries\US\Kentucky\CaneyvilleCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CaneyvilleCity\CaneyvilleCity as BaseCaneyvilleCity;
use Illuminate\Database\Eloquent\Collection;

class CaneyvilleCity extends BaseCaneyvilleCity
{
    public function compute(Collection $tax_areas)
    {
        $days_worked = $this->payroll->getDaysWorked(get_parent_class($this), $tax_areas->first()->workGovernmentalUnitArea);

        if (!$days_worked) {
            return 0.00;
        }

        $tax_amount = ($days_worked > 3) ? 4 : 2;

        return round($this->payroll->withholdTax($tax_amount), 2);
    }
}
