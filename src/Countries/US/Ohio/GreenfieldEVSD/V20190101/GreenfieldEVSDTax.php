<?php

namespace Appleton\Taxes\Countries\US\Ohio\GreenfieldEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\GreenfieldEVSD\GreenfieldEVSDTax as BaseGreenfieldEVSDTax;

class GreenfieldEVSDTax extends BaseGreenfieldEVSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
