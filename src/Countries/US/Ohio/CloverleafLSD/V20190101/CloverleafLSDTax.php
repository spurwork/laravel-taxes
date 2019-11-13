<?php

namespace Appleton\Taxes\Countries\US\Ohio\CloverleafLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CloverleafLSD\CloverleafLSDTax as BaseCloverleafLSDTax;

class CloverleafLSDTax extends BaseCloverleafLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
