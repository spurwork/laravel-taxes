<?php

namespace Appleton\Taxes\Countries\US\Ohio\BerneUnionLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BerneUnionLSD\BerneUnionLSDTax as BaseBerneUnionLSDTax;

class BerneUnionLSDTax extends BaseBerneUnionLSDTax
{
    public const TAX_RATE = 0.02;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
