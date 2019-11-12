<?php

namespace Appleton\Taxes\Countries\US\Ohio\RidgemontLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\RidgemontLSD\RidgemontLSDTax as BaseRidgemontLSDTax;

class RidgemontLSDTax extends BaseRidgemontLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
