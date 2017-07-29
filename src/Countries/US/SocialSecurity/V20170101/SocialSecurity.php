<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20170101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity as BaseSocialSecurity;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Traits\HasWageBase;

class SocialSecurity extends BaseSocialSecurity
{
    use HasWageBase;

    const TAX_RATE = 0.062;
    const WAGE_BASE = 127200;

    public function getAdjustedEarnings()
    {
        return $this->payroll->earnings < $this->getBaseEarnings() ? $this->payroll->earnings : $this->getBaseEarnings();
    }

    public function compute()
    {
        return round($this->getAdjustedEarnings() * static::TAX_RATE, 2);
    }
}
