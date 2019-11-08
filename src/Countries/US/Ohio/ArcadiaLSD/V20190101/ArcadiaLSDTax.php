<?php

namespace Appleton\Taxes\Countries\US\Ohio\ArcadiaLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ArcadiaLSD\ArcadiaLSDTax as BaseArcadiaLSDTax;

class ArcadiaLSDTax extends BaseArcadiaLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
