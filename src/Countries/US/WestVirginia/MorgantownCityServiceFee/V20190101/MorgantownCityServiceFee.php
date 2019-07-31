<?php


namespace Appleton\Taxes\Countries\US\WestVirginia\MorgantownCityServiceFee\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\MorgantownCityServiceFee\MorgantownCityServiceFee
    as BaseMorgantownCityServiceFee;
use Illuminate\Database\Eloquent\Collection;

class MorgantownCityServiceFee extends BaseMorgantownCityServiceFee
{
    public function compute(Collection $tax_areas)
    {
        if (0 !== $this->payroll->getWtdEarnings()) {
            return 0.00;
        }
        return 3.00;
    }
}