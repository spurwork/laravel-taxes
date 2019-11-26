<?php

namespace Appleton\Taxes\Countries\US\Ohio\TriVillageLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\TriVillageLSD\TriVillageLSDTax as BaseTriVillageLSDTax;

class TriVillageLSDTax extends BaseTriVillageLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
