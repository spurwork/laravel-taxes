<?php

namespace Appleton\Taxes\Countries\US\Ohio\PickeringtonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\PickeringtonLSD\PickeringtonLSDTax as BasePickeringtonLSDTax;

class PickeringtonLSDTax extends BasePickeringtonLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
