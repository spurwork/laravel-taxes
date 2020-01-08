<?php

namespace Appleton\Taxes\Countries\US\Ohio\PlymouthShilohLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\PlymouthShilohLSD\PlymouthShilohLSDTax as BasePlymouthShilohLSDTax;

class PlymouthShilohLSDTax extends BasePlymouthShilohLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
