<?php

namespace Appleton\Taxes\Countries\US\Ohio\LoudonvillePerrysvilleEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LoudonvillePerrysvilleEVSD\LoudonvillePerrysvilleEVSDTax as BaseLoudonvillePerrysvilleEVSDTax;

class LoudonvillePerrysvilleEVSDTax extends BaseLoudonvillePerrysvilleEVSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
