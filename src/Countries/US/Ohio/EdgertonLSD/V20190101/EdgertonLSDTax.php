<?php

namespace Appleton\Taxes\Countries\US\Ohio\EdgertonLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\EdgertonLSD\EdgertonLSDTax as BaseEdgertonLSDTax;

class EdgertonLSDTax extends BaseEdgertonLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
