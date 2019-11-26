<?php

namespace Appleton\Taxes\Countries\US\Ohio\HolgateLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HolgateLSD\HolgateLSDTax as BaseHolgateLSDTax;

class HolgateLSDTax extends BaseHolgateLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
