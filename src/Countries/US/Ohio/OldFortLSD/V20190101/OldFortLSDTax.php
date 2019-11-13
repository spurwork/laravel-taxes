<?php

namespace Appleton\Taxes\Countries\US\Ohio\OldFortLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\OldFortLSD\OldFortLSDTax as BaseOldFortLSDTax;

class OldFortLSDTax extends BaseOldFortLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
