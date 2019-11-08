<?php

namespace Appleton\Taxes\Countries\US\Ohio\PerrysburgEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\PerrysburgEVSD\PerrysburgEVSDTax as BasePerrysburgEVSDTax;

class PerrysburgEVSDTax extends BasePerrysburgEVSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
