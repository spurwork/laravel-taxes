<?php

namespace Appleton\Taxes\Countries\US\Ohio\AyersvilleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\AyersvilleLSD\AyersvilleLSDTax as BaseAyersvilleLSDTax;

class AyersvilleLSDTax extends BaseAyersvilleLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
