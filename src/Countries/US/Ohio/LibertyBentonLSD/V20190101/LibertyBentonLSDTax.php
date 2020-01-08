<?php

namespace Appleton\Taxes\Countries\US\Ohio\LibertyBentonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\LibertyBentonLSD\LibertyBentonLSDTax as BaseLibertyBentonLSDTax;

class LibertyBentonLSDTax extends BaseLibertyBentonLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
