<?php

namespace Appleton\Taxes\Countries\US\Ohio\HillsboroCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HillsboroCSD\HillsboroCSDTax as BaseHillsboroCSDTax;

class HillsboroCSDTax extends BaseHillsboroCSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
