<?php

namespace Appleton\Taxes\Countries\US\Ohio\CarlisleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CarlisleLSD\CarlisleLSDTax as BaseCarlisleLSDTax;

class CarlisleLSDTax extends BaseCarlisleLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
