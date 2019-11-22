<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthwesternLSDTraditional\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorthwesternLSDTraditional\NorthwesternLSDTraditionalTax as BaseNorthwesternLSDTraditionalTax;

class NorthwesternLSDTraditionalTax extends BaseNorthwesternLSDTraditionalTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
