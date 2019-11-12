<?php

namespace Appleton\Taxes\Countries\US\Ohio\EdonNorthwestLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\EdonNorthwestLSD\EdonNorthwestLSDTax as BaseEdonNorthwestLSDTax;

class EdonNorthwestLSDTax extends BaseEdonNorthwestLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
