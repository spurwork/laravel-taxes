<?php

namespace Appleton\Taxes\Countries\US\Oregon\SandyEmployer\V20190101;

use Appleton\Taxes\Countries\US\Oregon\SandyEmployer\SandyEmployer as BaseSandyEmployer;
use Illuminate\Database\Eloquent\Collection;

class SandyEmployer extends BaseSandyEmployer
{
    public function compute(Collection $tax_areas)
    {
        return 0.0;
    }
}
