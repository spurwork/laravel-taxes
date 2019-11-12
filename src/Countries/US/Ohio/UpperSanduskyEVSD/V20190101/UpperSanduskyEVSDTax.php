<?php

namespace Appleton\Taxes\Countries\US\Ohio\UpperSanduskyEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\UpperSanduskyEVSD\UpperSanduskyEVSDTax as BaseUpperSanduskyEVSDTax;

class UpperSanduskyEVSDTax extends BaseUpperSanduskyEVSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
