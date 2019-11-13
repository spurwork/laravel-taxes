<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewtonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NewtonLSD\NewtonLSDTax as BaseNewtonLSDTax;

class NewtonLSDTax extends BaseNewtonLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
