<?php

namespace Appleton\Taxes\Countries\US\Ohio\RossLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\RossLSD\RossLSDTax as BaseRossLSDTax;

class RossLSDTax extends BaseRossLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
