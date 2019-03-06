<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20190101;

use Illuminate\Database\Eloquent\Collection;

class SocialSecurityEmployer extends SocialSecurity
{
    const WITHHELD = false;

    public function compute(Collection $tax_areas)
    {
        return round($this->getAdjustedEarnings() * static::TAX_RATE, 2);
    }
}
