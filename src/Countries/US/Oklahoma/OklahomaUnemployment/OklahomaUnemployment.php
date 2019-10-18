<?php

namespace Appleton\Taxes\Countries\US\Oklahoma\OklahomaUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class OklahomaUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;

    public function compute(Collection $tax_areas)
    {
        return (int)round(intval(($this->getAdjustedEarnings() * $this->tax_rate) * 100) / 100, 0);
    }
}
