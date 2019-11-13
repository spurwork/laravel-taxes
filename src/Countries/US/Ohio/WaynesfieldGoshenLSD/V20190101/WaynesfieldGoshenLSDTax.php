<?php

namespace Appleton\Taxes\Countries\US\Ohio\WaynesfieldGoshenLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WaynesfieldGoshenLSD\WaynesfieldGoshenLSDTax as BaseWaynesfieldGoshenLSDTax;

class WaynesfieldGoshenLSDTax extends BaseWaynesfieldGoshenLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
