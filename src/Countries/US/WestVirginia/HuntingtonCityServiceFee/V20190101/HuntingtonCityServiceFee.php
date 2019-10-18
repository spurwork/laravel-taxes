<?php


namespace Appleton\Taxes\Countries\US\WestVirginia\HuntingtonCityServiceFee\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\HuntingtonCityServiceFee\HuntingtonCityServiceFee as BaseHuntingtonCityServiceFee;
use Illuminate\Database\Eloquent\Collection;

class HuntingtonCityServiceFee extends BaseHuntingtonCityServiceFee
{
    public function compute(Collection $tax_areas)
    {
        if (0.0 !== $this->payroll->getEarnings($tax_areas->first()->workGovernmentalUnitArea)) {
            return 5.0;
        }
        return 0.0;
    }
}
