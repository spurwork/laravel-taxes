<?php

namespace Appleton\Taxes\Countries\US\Ohio\WesternReserveLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WesternReserveLSD\WesternReserveLSDTax as BaseWesternReserveLSDTax;

class WesternReserveLSDTax extends BaseWesternReserveLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
