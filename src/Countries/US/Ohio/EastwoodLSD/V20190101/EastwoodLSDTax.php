<?php

namespace Appleton\Taxes\Countries\US\Ohio\EastwoodLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\EastwoodLSD\EastwoodLSDTax as BaseEastwoodLSDTax;

class EastwoodLSDTax extends BaseEastwoodLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
