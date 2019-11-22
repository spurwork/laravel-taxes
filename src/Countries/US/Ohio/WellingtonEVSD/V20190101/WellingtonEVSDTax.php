<?php

namespace Appleton\Taxes\Countries\US\Ohio\WellingtonEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WellingtonEVSD\WellingtonEVSDTax as BaseWellingtonEVSDTax;

class WellingtonEVSDTax extends BaseWellingtonEVSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
