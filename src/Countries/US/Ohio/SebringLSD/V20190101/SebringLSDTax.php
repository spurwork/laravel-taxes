<?php

namespace Appleton\Taxes\Countries\US\Ohio\SebringLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SebringLSD\SebringLSDTax as BaseSebringLSDTax;

class SebringLSDTax extends BaseSebringLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
