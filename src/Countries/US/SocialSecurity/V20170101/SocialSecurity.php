<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20170101;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

class SocialSecurity extends BaseTax
{
    use HasWageBase;

    const TYPE = 'federal';
    const WITHHELD = true;

    const TAX_RATE = 0.062;
    const WAGE_BASE = 127200;

    public function getAdjustedEarnings()
    {
        return $this->earnings < $this->getBaseEarnings() ? $this->earnings : $this->getBaseEarnings();
    }

    public function compute()
    {
        return round($this->getAdjustedEarnings() * static::TAX_RATE, 2);
    }
}
