<?php

namespace Appleton\Taxes\Countries\US\Ohio\ClearForkValleyLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ClearForkValleyLSD\ClearForkValleyLSDTax as BaseClearForkValleyLSDTax;

class ClearForkValleyLSDTax extends BaseClearForkValleyLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
