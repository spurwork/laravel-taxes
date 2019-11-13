<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewLebanonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NewLebanonLSD\NewLebanonLSDTax as BaseNewLebanonLSDTax;

class NewLebanonLSDTax extends BaseNewLebanonLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
