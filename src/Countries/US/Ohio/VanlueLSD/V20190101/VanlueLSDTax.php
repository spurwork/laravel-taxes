<?php

namespace Appleton\Taxes\Countries\US\Ohio\VanlueLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\VanlueLSD\VanlueLSDTax as BaseVanlueLSDTax;

class VanlueLSDTax extends BaseVanlueLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
