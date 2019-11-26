<?php

namespace Appleton\Taxes\Countries\US\Ohio\UnitedLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\UnitedLSD\UnitedLSDTax as BaseUnitedLSDTax;

class UnitedLSDTax extends BaseUnitedLSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
