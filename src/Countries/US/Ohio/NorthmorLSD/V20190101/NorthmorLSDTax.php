<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthmorLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NorthmorLSD\NorthmorLSDTax as BaseNorthmorLSDTax;

class NorthmorLSDTax extends BaseNorthmorLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
