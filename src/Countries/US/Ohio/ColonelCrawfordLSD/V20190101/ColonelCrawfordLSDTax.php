<?php

namespace Appleton\Taxes\Countries\US\Ohio\ColonelCrawfordLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ColonelCrawfordLSD\ColonelCrawfordLSDTax as BaseColonelCrawfordLSDTax;

class ColonelCrawfordLSDTax extends BaseColonelCrawfordLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
