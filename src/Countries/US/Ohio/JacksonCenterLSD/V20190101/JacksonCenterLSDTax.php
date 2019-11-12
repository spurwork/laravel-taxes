<?php

namespace Appleton\Taxes\Countries\US\Ohio\JacksonCenterLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\JacksonCenterLSD\JacksonCenterLSDTax as BaseJacksonCenterLSDTax;

class JacksonCenterLSDTax extends BaseJacksonCenterLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
