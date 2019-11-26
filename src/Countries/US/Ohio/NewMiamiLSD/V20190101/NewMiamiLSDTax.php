<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewMiamiLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NewMiamiLSD\NewMiamiLSDTax as BaseNewMiamiLSDTax;

class NewMiamiLSDTax extends BaseNewMiamiLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
