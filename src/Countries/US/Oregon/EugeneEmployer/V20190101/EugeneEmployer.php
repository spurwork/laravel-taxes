<?php

namespace Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\V20190101;

use Appleton\Taxes\Countries\US\Oregon\EugeneEmployer\EugeneEmployer as BaseEugeneEmployer;
use Illuminate\Database\Eloquent\Collection;

class EugeneEmployer extends BaseEugeneEmployer
{
    public function compute(Collection $tax_areas)
    {
        return 0.0;
    }
}
