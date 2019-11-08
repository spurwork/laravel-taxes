<?php

namespace Appleton\Taxes\Countries\US\Ohio\CovingtonEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CovingtonEVSD\CovingtonEVSDTax as BaseCovingtonEVSDTax;

class CovingtonEVSDTax extends BaseCovingtonEVSDTax
{
    public const TAX_RATE = 0.02;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
