<?php

namespace Appleton\Taxes\Countries\US\Ohio\PatrickHenryLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\PatrickHenryLSD\PatrickHenryLSDTax as BasePatrickHenryLSDTax;

class PatrickHenryLSDTax extends BasePatrickHenryLSDTax
{
    public const TAX_RATE = 0.0175;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
