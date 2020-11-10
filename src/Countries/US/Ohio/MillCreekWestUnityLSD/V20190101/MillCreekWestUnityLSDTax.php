<?php

namespace Appleton\Taxes\Countries\US\Ohio\MillCreekWestUnityLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MillcreekWestUnityLSD\MillCreekWestUnityLSDTax as BaseMillCreekWestUnityLSDTax;

class MillCreekWestUnityLSDTax extends BaseMillcreekWestUnityLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
