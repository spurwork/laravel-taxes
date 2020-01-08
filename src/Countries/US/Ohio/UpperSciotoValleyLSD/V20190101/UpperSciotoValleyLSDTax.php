<?php

namespace Appleton\Taxes\Countries\US\Ohio\UpperSciotoValleyLSD\V20190101;

use Appleton\Taxes\Countries\US\Ohio\UpperSciotoValleyLSD\UpperSciotoValleyLSDTax as BaseUpperSciotoValleyLSDTax;

class UpperSciotoValleyLSDTax extends BaseUpperSciotoValleyLSDTax
{
    public const TAX_RATE = 0.005;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}
