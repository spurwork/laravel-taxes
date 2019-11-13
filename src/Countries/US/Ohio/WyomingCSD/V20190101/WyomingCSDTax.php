<?php

namespace Appleton\Taxes\Countries\US\Ohio\WyomingCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WyomingCSD\WyomingCSDTax as BaseWyomingCSDTax;

class WyomingCSDTax extends BaseWyomingCSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
