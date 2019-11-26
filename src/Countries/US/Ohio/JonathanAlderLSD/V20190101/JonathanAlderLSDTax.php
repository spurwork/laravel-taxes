<?php

namespace Appleton\Taxes\Countries\US\Ohio\JonathanAlderLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\JonathanAlderLSD\JonathanAlderLSDTax as BaseJonathanAlderLSDTax;

class JonathanAlderLSDTax extends BaseJonathanAlderLSDTax
{
    public const TAX_RATE = 0.0125;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
