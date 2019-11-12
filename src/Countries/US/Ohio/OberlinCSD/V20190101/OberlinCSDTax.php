<?php

namespace Appleton\Taxes\Countries\US\Ohio\OberlinCSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\OberlinCSD\OberlinCSDTax as BaseOberlinCSDTax;

class OberlinCSDTax extends BaseOberlinCSDTax
{
    public const TAX_RATE = 0.02;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
