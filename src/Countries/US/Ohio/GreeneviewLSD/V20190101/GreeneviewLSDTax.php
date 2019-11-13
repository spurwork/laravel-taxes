<?php

namespace Appleton\Taxes\Countries\US\Ohio\GreeneviewLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\GreeneviewLSD\GreeneviewLSDTax as BaseGreeneviewLSDTax;

class GreeneviewLSDTax extends BaseGreeneviewLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
