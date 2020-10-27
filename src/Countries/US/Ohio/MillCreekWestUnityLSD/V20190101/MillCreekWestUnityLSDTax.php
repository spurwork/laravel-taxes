<?php

namespace Appleton\Taxes\Countries\US\Ohio\MillcreekWestUnityLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MillcreekWestUnityLSD\MillCreekWestUnityLSDTax as BaseMillcreekWestUnityLSDTax;

class MillCreekWestUnityLSDTax extends BaseMillcreekWestUnityLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
