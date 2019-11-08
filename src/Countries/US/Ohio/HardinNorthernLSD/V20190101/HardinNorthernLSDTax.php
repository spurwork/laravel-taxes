<?php

namespace Appleton\Taxes\Countries\US\Ohio\HardinNorthernLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\HardinNorthernLSD\HardinNorthernLSDTax as BaseHardinNorthernLSDTax;

class HardinNorthernLSDTax extends BaseHardinNorthernLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
