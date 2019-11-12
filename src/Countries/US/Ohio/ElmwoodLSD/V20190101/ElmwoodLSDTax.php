<?php

namespace Appleton\Taxes\Countries\US\Ohio\ElmwoodLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ElmwoodLSD\ElmwoodLSDTax as BaseElmwoodLSDTax;

class ElmwoodLSDTax extends BaseElmwoodLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
