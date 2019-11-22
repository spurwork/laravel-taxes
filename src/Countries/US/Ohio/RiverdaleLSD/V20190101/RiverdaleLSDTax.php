<?php

namespace Appleton\Taxes\Countries\US\Ohio\RiverdaleLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\RiverdaleLSD\RiverdaleLSDTax as BaseRiverdaleLSDTax;

class RiverdaleLSDTax extends BaseRiverdaleLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
