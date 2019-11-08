<?php

namespace Appleton\Taxes\Countries\US\Ohio\SwantonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SwantonLSD\SwantonLSDTax as BaseSwantonLSDTax;

class SwantonLSDTax extends BaseSwantonLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
