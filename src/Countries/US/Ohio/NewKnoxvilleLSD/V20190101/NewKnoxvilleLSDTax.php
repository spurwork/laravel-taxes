<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewKnoxvilleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NewKnoxvilleLSD\NewKnoxvilleLSDTax as BaseNewKnoxvilleLSDTax;

class NewKnoxvilleLSDTax extends BaseNewKnoxvilleLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
