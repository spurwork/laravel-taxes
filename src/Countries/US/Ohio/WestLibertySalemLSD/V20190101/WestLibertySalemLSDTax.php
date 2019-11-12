<?php

namespace Appleton\Taxes\Countries\US\Ohio\WestLibertySalemLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\WestLibertySalemLSD\WestLibertySalemLSDTax as BaseWestLibertySalemLSDTax;

class WestLibertySalemLSDTax extends BaseWestLibertySalemLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
