<?php

namespace Appleton\Taxes\Countries\US\Ohio\SouthCentralLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SouthCentralLSD\SouthCentralLSDTax as BaseSouthCentralLSDTax;

class SouthCentralLSDTax extends BaseSouthCentralLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
