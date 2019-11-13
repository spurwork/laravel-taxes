<?php

namespace Appleton\Taxes\Countries\US\Ohio\DanvilleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\DanvilleLSD\DanvilleLSDTax as BaseDanvilleLSDTax;

class DanvilleLSDTax extends BaseDanvilleLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
