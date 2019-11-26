<?php

namespace Appleton\Taxes\Countries\US\Ohio\WilmingtonCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WilmingtonCSD\WilmingtonCSDTax as BaseWilmingtonCSDTax;

class WilmingtonCSDTax extends BaseWilmingtonCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
