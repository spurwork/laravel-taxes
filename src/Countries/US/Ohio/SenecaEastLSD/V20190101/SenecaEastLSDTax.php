<?php

namespace Appleton\Taxes\Countries\US\Ohio\SenecaEastLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\SenecaEastLSD\SenecaEastLSDTax as BaseSenecaEastLSDTax;

class SenecaEastLSDTax extends BaseSenecaEastLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
