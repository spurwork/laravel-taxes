<?php

namespace Appleton\Taxes\Countries\US\Ohio\ClermontNortheasternLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\ClermontNortheasternLSD\ClermontNortheasternLSDTax as BaseClermontNortheasternLSDTax;

class ClermontNortheasternLSDTax extends BaseClermontNortheasternLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
