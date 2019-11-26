<?php

namespace Appleton\Taxes\Countries\US\Ohio\ElginLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ElginLSD\ElginLSDTax as BaseElginLSDTax;

class ElginLSDTax extends BaseElginLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
