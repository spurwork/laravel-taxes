<?php

namespace Appleton\Taxes\Countries\US\WestVirginia\CharlestonCityServiceFee\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\CharlestonCityServiceFee\CharlestonCityServiceFee as BaseCharlestonCityServiceFee;
use Illuminate\Database\Eloquent\Collection;

class CharlestonCityServiceFee extends BaseCharlestonCityServiceFee
{
    public function compute(Collection $tax_areas)
    {
        return 3.0;
    }
}
