<?php

namespace Appleton\Taxes\Countries\US\Oregon\WilsonvilleEmployer\V20190101;

use Appleton\Taxes\Countries\US\Oregon\WilsonvilleEmployer\WilsonvilleEmployer as BaseWilsonvilleEmployer;
use Illuminate\Database\Eloquent\Collection;

class WilsonvilleEmployer extends BaseWilsonvilleEmployer
{
    public function compute(Collection $tax_areas)
    {
        return 0.0;
    }
}
