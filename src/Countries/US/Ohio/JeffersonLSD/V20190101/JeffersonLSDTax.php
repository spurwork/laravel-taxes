<?php

namespace Appleton\Taxes\Countries\US\Ohio\JeffersonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\JeffersonLSD\JeffersonLSDTax as BaseJeffersonLSDTax;

class JeffersonLSDTax extends BaseJeffersonLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
