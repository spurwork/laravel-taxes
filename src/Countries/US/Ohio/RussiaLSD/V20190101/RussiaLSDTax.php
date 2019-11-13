<?php

namespace Appleton\Taxes\Countries\US\Ohio\RussiaLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\RussiaLSD\RussiaLSDTax as BaseRussiaLSDTax;

class RussiaLSDTax extends BaseRussiaLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
