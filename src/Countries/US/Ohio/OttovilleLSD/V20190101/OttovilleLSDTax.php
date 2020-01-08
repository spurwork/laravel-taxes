<?php

namespace Appleton\Taxes\Countries\US\Ohio\OttovilleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\OttovilleLSD\OttovilleLSDTax as BaseOttovilleLSDTax;

class OttovilleLSDTax extends BaseOttovilleLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
