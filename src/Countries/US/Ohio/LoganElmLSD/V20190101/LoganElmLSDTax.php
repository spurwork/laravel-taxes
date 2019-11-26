<?php

namespace Appleton\Taxes\Countries\US\Ohio\LoganElmLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LoganElmLSD\LoganElmLSDTax as BaseLoganElmLSDTax;

class LoganElmLSDTax extends BaseLoganElmLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
