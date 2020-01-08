<?php

namespace Appleton\Taxes\Countries\US\Ohio\MadisonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MadisonLSD\MadisonLSDTax as BaseMadisonLSDTax;

class MadisonLSDTax extends BaseMadisonLSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
