<?php

namespace Appleton\Taxes\Countries\US\Ohio\McCombLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\McCombLSD\McCombLSDTax as BaseMcCombLSDTax;

class McCombLSDTax extends BaseMcCombLSDTax
{
    public const TAX_RATE = 0.015;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
