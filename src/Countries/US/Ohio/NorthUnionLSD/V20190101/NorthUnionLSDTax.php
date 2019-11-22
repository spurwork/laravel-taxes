<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthUnionLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorthUnionLSD\NorthUnionLSDTax as BaseNorthUnionLSDTax;

class NorthUnionLSDTax extends BaseNorthUnionLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
