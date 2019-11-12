<?php

namespace Appleton\Taxes\Countries\US\Ohio\TriCountyNorthLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TriCountyNorthLSD\TriCountyNorthLSDTax as BaseTriCountyNorthLSDTax;

class TriCountyNorthLSDTax extends BaseTriCountyNorthLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
