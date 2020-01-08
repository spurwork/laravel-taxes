<?php

namespace Appleton\Taxes\Countries\US\Ohio\CentralLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CentralLSD\CentralLSDTax as BaseCentralLSDTax;

class CentralLSDTax extends BaseCentralLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
