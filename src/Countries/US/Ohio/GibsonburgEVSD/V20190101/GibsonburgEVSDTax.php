<?php

namespace Appleton\Taxes\Countries\US\Ohio\GibsonburgEVSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\GibsonburgEVSD\GibsonburgEVSDTax as BaseGibsonburgEVSDTax;

class GibsonburgEVSDTax extends BaseGibsonburgEVSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
