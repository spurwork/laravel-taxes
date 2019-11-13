<?php

namespace Appleton\Taxes\Countries\US\Ohio\AdaEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\AdaEVSD\AdaEVSDTax as BaseAdaEVSDTax;

class AdaEVSDTax extends BaseAdaEVSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
