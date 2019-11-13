<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthwoodLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorthwoodLSD\NorthwoodLSDTax as BaseNorthwoodLSDTax;

class NorthwoodLSDTax extends BaseNorthwoodLSDTax
{
    public const TAX_RATE = 0.0025;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
