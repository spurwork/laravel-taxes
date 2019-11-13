<?php

namespace Appleton\Taxes\Countries\US\Ohio\ArlingtonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ArlingtonLSD\ArlingtonLSDTax as BaseArlingtonLSDTax;

class ArlingtonLSDTax extends BaseArlingtonLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
