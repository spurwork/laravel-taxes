<?php

namespace Appleton\Taxes\Countries\US\Oregon\Eugene\V20190101;

use Appleton\Taxes\Countries\US\Oregon\Eugene\Eugene as BaseEugene;

use Illuminate\Database\Eloquent\Collection;

class Eugene extends BaseEugene
{
    public function compute(Collection $tax_areas)
    {
        return 0.0;
    }
}
