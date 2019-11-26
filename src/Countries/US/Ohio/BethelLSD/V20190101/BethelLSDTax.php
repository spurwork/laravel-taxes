<?php

namespace Appleton\Taxes\Countries\US\Ohio\BethelLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BethelLSD\BethelLSDTax as BaseBethelLSDTax;

class BethelLSDTax extends BaseBethelLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
