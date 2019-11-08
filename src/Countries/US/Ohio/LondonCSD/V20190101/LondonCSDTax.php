<?php

namespace Appleton\Taxes\Countries\US\Ohio\LondonCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LondonCSD\LondonCSDTax as BaseLondonCSDTax;

class LondonCSDTax extends BaseLondonCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
