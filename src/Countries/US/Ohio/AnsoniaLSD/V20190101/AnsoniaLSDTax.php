<?php

namespace Appleton\Taxes\Countries\US\Ohio\AnsoniaLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\AnsoniaLSD\AnsoniaLSDTax as BaseAnsoniaLSDTax;

class AnsoniaLSDTax extends BaseAnsoniaLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
