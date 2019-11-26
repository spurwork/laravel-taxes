<?php

namespace Appleton\Taxes\Countries\US\Ohio\GorhamFayetteLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\GorhamFayetteLSD\GorhamFayetteLSDTax as BaseGorhamFayetteLSDTax;

class GorhamFayetteLSDTax extends BaseGorhamFayetteLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
