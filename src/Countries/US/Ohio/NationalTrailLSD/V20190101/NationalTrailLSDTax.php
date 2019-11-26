<?php

namespace Appleton\Taxes\Countries\US\Ohio\NationalTrailLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NationalTrailLSD\NationalTrailLSDTax as BaseNationalTrailLSDTax;

class NationalTrailLSDTax extends BaseNationalTrailLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
