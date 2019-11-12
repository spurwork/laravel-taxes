<?php

namespace Appleton\Taxes\Countries\US\Ohio\CrestlineEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CrestlineEVSD\CrestlineEVSDTax as BaseCrestlineEVSDTax;

class CrestlineEVSDTax extends BaseCrestlineEVSDTax
{
    public const TAX_RATE = 0.0025;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
