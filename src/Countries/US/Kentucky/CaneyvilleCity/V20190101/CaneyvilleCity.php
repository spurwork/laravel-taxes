<?php

namespace Appleton\Taxes\Countries\US\Kentucky\CaneyvilleCity\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\CaneyvilleCity\CaneyvilleCity as BaseCaneyvilleCity;
use Illuminate\Database\Eloquent\Collection;

class CaneyvilleCity extends BaseCaneyvilleCity
{
    public function compute(Collection $tax_areas)
    {
        $tax_amount = ($this->payroll->getDaysWorked(get_class($this), $tax_areas->first()->workGovernmentalUnitArea) > 3) ? 4 : 2;

        return round($this->payroll->withholdTax($tax_amount), 2);
    }
}
