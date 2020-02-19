<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20180101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity as BaseSocialSecurity;

class SocialSecurity extends BaseSocialSecurity
{
    public const TAX_RATE = 0.062;
    public const WAGE_BASE = 128400;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
