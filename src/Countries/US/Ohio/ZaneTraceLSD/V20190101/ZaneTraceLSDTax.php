<?php

namespace Appleton\Taxes\Countries\US\Ohio\ZaneTraceLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ZaneTraceLSD\ZaneTraceLSDTax as BaseZaneTraceLSDTax;

class ZaneTraceLSDTax extends BaseZaneTraceLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
