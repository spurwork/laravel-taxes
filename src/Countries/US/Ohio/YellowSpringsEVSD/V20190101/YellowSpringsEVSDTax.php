<?php

namespace Appleton\Taxes\Countries\US\Ohio\YellowSpringsEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\YellowSpringsEVSD\YellowSpringsEVSDTax as BaseYellowSpringsEVSDTax;

class YellowSpringsEVSDTax extends BaseYellowSpringsEVSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
