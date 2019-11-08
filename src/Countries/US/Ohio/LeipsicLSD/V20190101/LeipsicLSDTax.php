<?php

namespace Appleton\Taxes\Countries\US\Ohio\LeipsicLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LeipsicLSD\LeipsicLSDTax as BaseLeipsicLSDTax;

class LeipsicLSDTax extends BaseLeipsicLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
