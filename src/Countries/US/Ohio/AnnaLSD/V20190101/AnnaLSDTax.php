<?php

namespace Appleton\Taxes\Countries\US\Ohio\AnnaLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\AnnaLSD\AnnaLSDTax as BaseAnnaLSDTax;

class AnnaLSDTax extends BaseAnnaLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
