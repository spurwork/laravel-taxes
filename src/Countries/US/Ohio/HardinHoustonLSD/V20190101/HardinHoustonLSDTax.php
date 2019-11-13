<?php

namespace Appleton\Taxes\Countries\US\Ohio\HardinHoustonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HardinHoustonLSD\HardinHoustonLSDTax as BaseHardinHoustonLSDTax;

class HardinHoustonLSDTax extends BaseHardinHoustonLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
