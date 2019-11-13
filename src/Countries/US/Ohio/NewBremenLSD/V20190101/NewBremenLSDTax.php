<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewBremenLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\NewBremenLSD\NewBremenLSDTax as BaseNewBremenLSDTax;

class NewBremenLSDTax extends BaseNewBremenLSDTax
{
    public const TAX_RATE = 0.01;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
