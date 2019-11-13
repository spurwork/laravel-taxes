<?php

namespace Appleton\Taxes\Countries\US\Ohio\LibertyCenterLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LibertyCenterLSD\LibertyCenterLSDTax as BaseLibertyCenterLSDTax;

class LibertyCenterLSDTax extends BaseLibertyCenterLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
