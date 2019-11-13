<?php

namespace Appleton\Taxes\Countries\US\Ohio\JenningsLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\JenningsLSD\JenningsLSDTax as BaseJenningsLSDTax;

class JenningsLSDTax extends BaseJenningsLSDTax
{
    public const TAX_RATE = 0.0075;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
