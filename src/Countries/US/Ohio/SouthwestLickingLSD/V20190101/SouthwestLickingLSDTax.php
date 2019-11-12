<?php

namespace Appleton\Taxes\Countries\US\Ohio\SouthwestLickingLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SouthwestLickingLSD\SouthwestLickingLSDTax as BaseSouthwestLickingLSDTax;

class SouthwestLickingLSDTax extends BaseSouthwestLickingLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
