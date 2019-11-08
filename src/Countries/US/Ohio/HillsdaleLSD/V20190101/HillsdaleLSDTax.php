<?php

namespace Appleton\Taxes\Countries\US\Ohio\HillsdaleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HillsdaleLSD\HillsdaleLSDTax as BaseHillsdaleLSDTax;

class HillsdaleLSDTax extends BaseHillsdaleLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
