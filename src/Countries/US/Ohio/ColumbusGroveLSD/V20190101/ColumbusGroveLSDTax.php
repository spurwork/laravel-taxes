<?php

namespace Appleton\Taxes\Countries\US\Ohio\ColumbusGroveLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ColumbusGroveLSD\ColumbusGroveLSDTax as BaseColumbusGroveLSDTax;

class ColumbusGroveLSDTax extends BaseColumbusGroveLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
