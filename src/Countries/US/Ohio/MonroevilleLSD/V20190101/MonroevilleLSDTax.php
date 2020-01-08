<?php

namespace Appleton\Taxes\Countries\US\Ohio\MonroevilleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\MonroevilleLSD\MonroevilleLSDTax as BaseMonroevilleLSDTax;

class MonroevilleLSDTax extends BaseMonroevilleLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
