<?php

namespace Appleton\Taxes\Countries\US\Oklahoma\OklahomaUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class OklahomaUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;

    public function compute(Collection $tax_areas)
    {
        return (int)round($this->getAdjustedEarnings() * $this->tax_rate, 2);
    }
}
