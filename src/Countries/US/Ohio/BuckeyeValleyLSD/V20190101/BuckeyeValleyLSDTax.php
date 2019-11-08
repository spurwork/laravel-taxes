<?php

namespace Appleton\Taxes\Countries\US\Ohio\BuckeyeValleyLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BuckeyeValleyLSD\BuckeyeValleyLSDTax as BaseBuckeyeValleyLSDTax;

class BuckeyeValleyLSDTax extends BaseBuckeyeValleyLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
