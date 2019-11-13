<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewLondonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NewLondonLSD\NewLondonLSDTax as BaseNewLondonLSDTax;

class NewLondonLSDTax extends BaseNewLondonLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
