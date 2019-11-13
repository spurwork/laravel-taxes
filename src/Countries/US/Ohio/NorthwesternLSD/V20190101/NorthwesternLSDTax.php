<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthwesternLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorthwesternLSD\NorthwesternLSDTax as BaseNorthwesternLSDTax;

class NorthwesternLSDTax extends BaseNorthwesternLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
