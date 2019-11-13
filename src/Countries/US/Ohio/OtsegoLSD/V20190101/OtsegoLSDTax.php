<?php

namespace Appleton\Taxes\Countries\US\Ohio\OtsegoLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\OtsegoLSD\OtsegoLSDTax as BaseOtsegoLSDTax;

class OtsegoLSDTax extends BaseOtsegoLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
