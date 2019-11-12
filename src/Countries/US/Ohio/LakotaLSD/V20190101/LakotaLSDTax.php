<?php

namespace Appleton\Taxes\Countries\US\Ohio\LakotaLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LakotaLSD\LakotaLSDTax as BaseLakotaLSDTax;

class LakotaLSDTax extends BaseLakotaLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
