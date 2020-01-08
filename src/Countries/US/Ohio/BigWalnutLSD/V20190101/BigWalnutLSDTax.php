<?php

namespace Appleton\Taxes\Countries\US\Ohio\BigWalnutLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BigWalnutLSD\BigWalnutLSDTax as BaseBigWalnutLSDTax;

class BigWalnutLSDTax extends BaseBigWalnutLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
