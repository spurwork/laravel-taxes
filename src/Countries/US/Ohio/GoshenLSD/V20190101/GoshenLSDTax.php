<?php

namespace Appleton\Taxes\Countries\US\Ohio\GoshenLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\GoshenLSD\GoshenLSDTax as BaseGoshenLSDTax;

class GoshenLSDTax extends BaseGoshenLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
