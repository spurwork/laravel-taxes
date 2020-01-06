<?php

namespace Appleton\Taxes\Countries\US\Oregon\CanbyEmployer\V20190101;

use Appleton\Taxes\Countries\US\Oregon\CanbyEmployer\CanbyEmployer as BaseCanbyEmployer;
use Illuminate\Database\Eloquent\Collection;

class CanbyEmployer extends BaseCanbyEmployer
{
    public function compute(Collection $tax_areas)
    {
        return 0.0;
    }
}
