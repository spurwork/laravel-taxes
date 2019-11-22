<?php

namespace Appleton\Taxes\Countries\US\Ohio\CenterburgLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CenterburgLSD\CenterburgLSDTax as BaseCenterburgLSDTax;

class CenterburgLSDTax extends BaseCenterburgLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
