<?php

namespace Appleton\Taxes\Countries\US\Ohio\MohawkLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MohawkLSD\MohawkLSDTax as BaseMohawkLSDTax;

class MohawkLSDTax extends BaseMohawkLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
