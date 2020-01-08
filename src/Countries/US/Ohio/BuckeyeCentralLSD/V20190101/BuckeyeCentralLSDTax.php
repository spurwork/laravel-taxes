<?php

namespace Appleton\Taxes\Countries\US\Ohio\BuckeyeCentralLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BuckeyeCentralLSD\BuckeyeCentralLSDTax as BaseBuckeyeCentralLSDTax;

class BuckeyeCentralLSDTax extends BaseBuckeyeCentralLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
