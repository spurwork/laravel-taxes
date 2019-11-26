<?php

namespace Appleton\Taxes\Countries\US\Ohio\BlufftonEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BlufftonEVSD\BlufftonEVSDTax as BaseBlufftonEVSDTax;

class BlufftonEVSDTax extends BaseBlufftonEVSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
