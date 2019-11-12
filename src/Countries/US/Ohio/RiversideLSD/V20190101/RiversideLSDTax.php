<?php

namespace Appleton\Taxes\Countries\US\Ohio\RiversideLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\RiversideLSD\RiversideLSDTax as BaseRiversideLSDTax;

class RiversideLSDTax extends BaseRiversideLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
