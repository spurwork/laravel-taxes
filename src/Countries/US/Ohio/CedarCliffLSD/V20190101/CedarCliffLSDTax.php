<?php

namespace Appleton\Taxes\Countries\US\Ohio\CedarCliffLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CedarCliffLSD\CedarCliffLSDTax as BaseCedarCliffLSDTax;

class CedarCliffLSDTax extends BaseCedarCliffLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
