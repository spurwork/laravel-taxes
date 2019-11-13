<?php

namespace Appleton\Taxes\Countries\US\Ohio\ParkwayLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ParkwayLSD\ParkwayLSDTax as BaseParkwayLSDTax;

class ParkwayLSDTax extends BaseParkwayLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
