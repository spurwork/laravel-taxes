<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

class SocialSecurity extends BaseTax
{
    use HasWageBase;

    const TAX_RATE = 0.062;

    const WAGE_BASE = 127200;

    public function compute()
    {
        return round($this->getAdjustedEarnings() * self::TAX_RATE, 2);
    }
}
