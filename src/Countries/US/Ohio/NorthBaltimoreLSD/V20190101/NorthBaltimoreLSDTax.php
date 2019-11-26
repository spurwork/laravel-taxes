<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthBaltimoreLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorthBaltimoreLSD\NorthBaltimoreLSDTax as BaseNorthBaltimoreLSDTax;

class NorthBaltimoreLSDTax extends BaseNorthBaltimoreLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
