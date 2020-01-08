<?php

namespace Appleton\Taxes\Countries\US\Ohio\ContinentalLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ContinentalLSD\ContinentalLSDTax as BaseContinentalLSDTax;

class ContinentalLSDTax extends BaseContinentalLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
