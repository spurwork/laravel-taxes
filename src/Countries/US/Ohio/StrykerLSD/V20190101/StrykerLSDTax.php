<?php

namespace Appleton\Taxes\Countries\US\Ohio\StrykerLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\StrykerLSD\StrykerLSDTax as BaseStrykerLSDTax;

class StrykerLSDTax extends BaseStrykerLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
