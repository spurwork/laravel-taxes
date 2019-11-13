<?php

namespace Appleton\Taxes\Countries\US\Ohio\ValleyViewLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ValleyViewLSD\ValleyViewLSDTax as BaseValleyViewLSDTax;

class ValleyViewLSDTax extends BaseValleyViewLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
