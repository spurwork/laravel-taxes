<?php

namespace Appleton\Taxes\Countries\US\Ohio\TeaysValleyLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TeaysValleyLSD\TeaysValleyLSDTax as BaseTeaysValleyLSDTax;

class TeaysValleyLSDTax extends BaseTeaysValleyLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
