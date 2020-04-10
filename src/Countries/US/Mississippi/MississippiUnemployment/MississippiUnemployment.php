<?php

namespace Appleton\Taxes\Countries\US\Mississippi\MississippiUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class MississippiUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;

    public function compute(Collection $tax_areas)
    {
        return $this->calculateRoundedToDollar();
    }
}
