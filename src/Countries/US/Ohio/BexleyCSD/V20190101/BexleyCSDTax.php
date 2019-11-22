<?php

namespace Appleton\Taxes\Countries\US\Ohio\BexleyCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\BexleyCSD\BexleyCSDTax as BaseBexleyCSDTax;

class BexleyCSDTax extends BaseBexleyCSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
