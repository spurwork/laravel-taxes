<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthwestLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorthwestLSD\NorthwestLSDTax as BaseNorthwestLSDTax;

class NorthwestLSDTax extends BaseNorthwestLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
