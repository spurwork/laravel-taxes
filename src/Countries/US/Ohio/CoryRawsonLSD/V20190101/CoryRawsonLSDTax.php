<?php

namespace Appleton\Taxes\Countries\US\Ohio\CoryRawsonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\CoryRawsonLSD\CoryRawsonLSDTax as BaseCoryRawsonLSDTax;

class CoryRawsonLSDTax extends BaseCoryRawsonLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
