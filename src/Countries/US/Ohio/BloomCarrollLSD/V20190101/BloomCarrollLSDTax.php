<?php

namespace Appleton\Taxes\Countries\US\Ohio\BloomCarrollLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BloomCarrollLSD\BloomCarrollLSDTax as BaseBloomCarrollLSDTax;

class BloomCarrollLSDTax extends BaseBloomCarrollLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
