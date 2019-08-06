<?php

namespace Appleton\Taxes\Countries\US\WestVirginia\CharlestonCityServiceFee\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\CharlestonCityServiceFee\CharlestonCityServiceFee
    as BaseCharlestonCityServiceFee;
use Illuminate\Database\Eloquent\Collection;

class CharlestonCityServiceFee extends BaseCharlestonCityServiceFee
{
    public function compute(Collection $tax_areas)
    {
        if (0 !== $this->payroll->getWtdEarnings($tax_areas->first()->workGovernmentalUnitArea)) {
            return 0.00;
        }
        return 3.0;
    }
}