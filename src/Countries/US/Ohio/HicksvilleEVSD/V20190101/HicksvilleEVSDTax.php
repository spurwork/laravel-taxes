<?php

namespace Appleton\Taxes\Countries\US\Ohio\HicksvilleEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HicksvilleEVSD\HicksvilleEVSDTax as BaseHicksvilleEVSDTax;

class HicksvilleEVSDTax extends BaseHicksvilleEVSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
