<?php


namespace Appleton\Taxes\Countries\US\WestVirginia\ParkersburgCityServiceFee\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\ParkersburgCityServiceFee\ParkersburgCityServiceFee as
    BaseParkersburgCityServiceFee;
use Illuminate\Database\Eloquent\Collection;

class ParkersburgCityServiceFee extends BaseParkersburgCityServiceFee
{
    public function compute(Collection $tax_areas)
    {
        if (0 !== $this->payroll->getWtdEarnings($tax_areas->first()->workGovernmentalUnitArea)) {
            return 0.00;
        }
        return 2.50;
    }
}