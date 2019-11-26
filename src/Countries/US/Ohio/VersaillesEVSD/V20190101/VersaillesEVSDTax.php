<?php

namespace Appleton\Taxes\Countries\US\Ohio\VersaillesEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\VersaillesEVSD\VersaillesEVSDTax as BaseVersaillesEVSDTax;

class VersaillesEVSDTax extends BaseVersaillesEVSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
