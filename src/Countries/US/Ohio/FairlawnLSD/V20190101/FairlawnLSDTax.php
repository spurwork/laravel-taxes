<?php

namespace Appleton\Taxes\Countries\US\Ohio\FairlawnLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\FairlawnLSD\FairlawnLSDTax as BaseFairlawnLSDTax;

class FairlawnLSDTax extends BaseFairlawnLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
