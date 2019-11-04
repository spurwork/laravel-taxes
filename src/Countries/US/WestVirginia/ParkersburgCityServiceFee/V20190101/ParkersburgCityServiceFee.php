<?php


namespace Appleton\Taxes\Countries\US\WestVirginia\ParkersburgCityServiceFee\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\ParkersburgCityServiceFee\ParkersburgCityServiceFee as BaseParkersburgCityServiceFee;
use Illuminate\Database\Eloquent\Collection;

class ParkersburgCityServiceFee extends BaseParkersburgCityServiceFee
{
    public function compute(Collection $tax_areas)
    {
        if (0.0 !== $this->payroll->getEarnings($tax_areas->first()->workGovernmentalUnitArea)) {
            return 2.5;
        }
        return 0.0;
    }
}
