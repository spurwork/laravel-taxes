<?php

namespace Appleton\Taxes\Countries\US\Ohio\ClydeGreenSpringsEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ClydeGreenSpringsEVSD\ClydeGreenSpringsEVSDTax as BaseClydeGreenSpringsEVSDTax;

class ClydeGreenSpringsEVSDTax extends BaseClydeGreenSpringsEVSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
