<?php

namespace Appleton\Taxes\Countries\US\Ohio\WayneTraceLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WayneTraceLSD\WayneTraceLSDTax as BaseWayneTraceLSDTax;

class WayneTraceLSDTax extends BaseWayneTraceLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
