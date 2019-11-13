<?php

namespace Appleton\Taxes\Countries\US\Ohio\HighlandLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HighlandLSD\HighlandLSDTax as BaseHighlandLSDTax;

class HighlandLSDTax extends BaseHighlandLSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
