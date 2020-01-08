<?php

namespace Appleton\Taxes\Countries\US\Ohio\DaltonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\DaltonLSD\DaltonLSDTax as BaseDaltonLSDTax;

class DaltonLSDTax extends BaseDaltonLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
