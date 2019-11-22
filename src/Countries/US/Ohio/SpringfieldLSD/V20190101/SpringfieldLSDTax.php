<?php

namespace Appleton\Taxes\Countries\US\Ohio\SpringfieldLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SpringfieldLSD\SpringfieldLSDTax as BaseSpringfieldLSDTax;

class SpringfieldLSDTax extends BaseSpringfieldLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
