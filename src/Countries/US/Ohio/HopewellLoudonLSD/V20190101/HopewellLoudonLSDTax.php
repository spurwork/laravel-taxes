<?php

namespace Appleton\Taxes\Countries\US\Ohio\HopewellLoudonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HopewellLoudonLSD\HopewellLoudonLSDTax as BaseHopewellLoudonLSDTax;

class HopewellLoudonLSDTax extends BaseHopewellLoudonLSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
