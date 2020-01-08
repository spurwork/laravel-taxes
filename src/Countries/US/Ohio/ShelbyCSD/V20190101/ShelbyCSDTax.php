<?php

namespace Appleton\Taxes\Countries\US\Ohio\ShelbyCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ShelbyCSD\ShelbyCSDTax as BaseShelbyCSDTax;

class ShelbyCSDTax extends BaseShelbyCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
