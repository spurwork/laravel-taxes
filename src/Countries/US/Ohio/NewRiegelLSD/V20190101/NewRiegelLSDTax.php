<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewRiegelLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NewRiegelLSD\NewRiegelLSDTax as BaseNewRiegelLSDTax;

class NewRiegelLSDTax extends BaseNewRiegelLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
