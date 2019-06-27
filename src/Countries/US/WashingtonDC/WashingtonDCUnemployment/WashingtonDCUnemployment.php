<?php
namespace Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class WashingtonDCUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;

    // public function compute(Collection $tax_areas)
    // {
    //     return round(intval(($this->getAdjustedEarnings() * $this->tax_rate) * 100) / 100, 0);
    // }
}
