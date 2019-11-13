<?php

namespace Appleton\Taxes\Countries\US\Ohio\AntwerpLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\AntwerpLSD\AntwerpLSDTax as BaseAntwerpLSDTax;

class AntwerpLSDTax extends BaseAntwerpLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
