<?php

namespace Appleton\Taxes\Countries\US\Ohio\NortheasternLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NortheasternLSD\NortheasternLSDTax as BaseNortheasternLSDTax;

class NortheasternLSDTax extends BaseNortheasternLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
