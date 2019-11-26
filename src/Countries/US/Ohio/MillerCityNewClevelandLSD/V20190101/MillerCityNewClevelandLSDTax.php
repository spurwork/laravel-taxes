<?php

namespace Appleton\Taxes\Countries\US\Ohio\MillerCityNewClevelandLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MillerCityNewClevelandLSD\MillerCityNewClevelandLSDTax as BaseMillerCityNewClevelandLSDTax;

class MillerCityNewClevelandLSDTax extends BaseMillerCityNewClevelandLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
