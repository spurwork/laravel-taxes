<?php

namespace Appleton\Taxes\Countries\US\Ohio\EvergreenLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\EvergreenLSD\EvergreenLSDTax as BaseEvergreenLSDTax;

class EvergreenLSDTax extends BaseEvergreenLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
