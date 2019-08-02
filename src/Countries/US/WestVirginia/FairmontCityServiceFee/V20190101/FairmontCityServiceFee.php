<?php


namespace Appleton\Taxes\Countries\US\WestVirginia\FairmontCityServiceFee\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\FairmontCityServiceFee\FairmontCityServiceFee
    as BaseFairmontCityServiceFee;
use Illuminate\Database\Eloquent\Collection;

class FairmontCityServiceFee extends BaseFairmontCityServiceFee
{
    public function compute(Collection $tax_areas)
    {
        if (0 !== $this->payroll->getWtdEarnings()) {
            return 0.00;
        }
        return 2.00;
    }
}