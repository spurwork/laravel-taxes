<?php

namespace Appleton\Taxes\Countries\US\Ohio\LickingValleyLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LickingValleyLSD\LickingValleyLSDTax as BaseLickingValleyLSDTax;

class LickingValleyLSDTax extends BaseLickingValleyLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
