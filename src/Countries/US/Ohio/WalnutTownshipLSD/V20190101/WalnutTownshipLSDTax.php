<?php

namespace Appleton\Taxes\Countries\US\Ohio\WalnutTownshipLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WalnutTownshipLSD\WalnutTownshipLSDTax as BaseWalnutTownshipLSDTax;

class WalnutTownshipLSDTax extends BaseWalnutTownshipLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
