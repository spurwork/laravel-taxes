<?php

namespace Appleton\Taxes\Countries\US\Ohio\BotkinsLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BotkinsLSD\BotkinsLSDTax as BaseBotkinsLSDTax;

class BotkinsLSDTax extends BaseBotkinsLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
