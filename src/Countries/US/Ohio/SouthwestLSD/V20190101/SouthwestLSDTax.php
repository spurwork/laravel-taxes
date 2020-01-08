<?php

namespace Appleton\Taxes\Countries\US\Ohio\SouthwestLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SouthwestLSD\SouthwestLSDTax as BaseSouthwestLSDTax;

class SouthwestLSDTax extends BaseSouthwestLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
