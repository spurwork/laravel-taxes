<?php

namespace Appleton\Taxes\Countries\US\Ohio\CrestviewLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CrestviewLSD\CrestviewLSDTax as BaseCrestviewLSDTax;

class CrestviewLSDTax extends BaseCrestviewLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
