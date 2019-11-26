<?php

namespace Appleton\Taxes\Countries\US\Ohio\MinsterLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MinsterLSD\MinsterLSDTax as BaseMinsterLSDTax;

class MinsterLSDTax extends BaseMinsterLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
