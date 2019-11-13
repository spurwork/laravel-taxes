<?php

namespace Appleton\Taxes\Countries\US\Ohio\TriwayLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TriwayLSD\TriwayLSDTax as BaseTriwayLSDTax;

class TriwayLSDTax extends BaseTriwayLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
