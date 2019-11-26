<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthForkLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorthForkLSD\NorthForkLSDTax as BaseNorthForkLSDTax;

class NorthForkLSDTax extends BaseNorthForkLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
