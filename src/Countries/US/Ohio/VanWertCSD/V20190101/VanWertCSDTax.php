<?php

namespace Appleton\Taxes\Countries\US\Ohio\VanWertCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\VanWertCSD\VanWertCSDTax as BaseVanWertCSDTax;

class VanWertCSDTax extends BaseVanWertCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
