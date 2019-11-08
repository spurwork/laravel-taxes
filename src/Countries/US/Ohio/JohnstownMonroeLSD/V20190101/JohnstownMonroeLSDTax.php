<?php

namespace Appleton\Taxes\Countries\US\Ohio\JohnstownMonroeLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\JohnstownMonroeLSD\JohnstownMonroeLSDTax as BaseJohnstownMonroeLSDTax;

class JohnstownMonroeLSDTax extends BaseJohnstownMonroeLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
