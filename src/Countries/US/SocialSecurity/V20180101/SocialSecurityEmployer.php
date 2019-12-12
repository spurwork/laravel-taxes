<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20180101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer as BaseSocialSecurityEmployer;

class SocialSecurityEmployer extends BaseSocialSecurityEmployer
{
    public const TAX_RATE = SocialSecurity::TAX_RATE;
    public const WAGE_BASE = SocialSecurity::WAGE_BASE;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
