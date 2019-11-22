<?php

namespace Appleton\Taxes\Countries\US\Ohio\CardingtonLincolnLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CardingtonLincolnLSD\CardingtonLincolnLSDTax as BaseCardingtonLincolnLSDTax;

class CardingtonLincolnLSDTax extends BaseCardingtonLincolnLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
