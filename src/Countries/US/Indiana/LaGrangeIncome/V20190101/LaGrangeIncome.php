<?php

namespace Appleton\Taxes\Countries\US\Indiana\LaGrangeIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\LaGrangeIncome\LaGrangeIncome as BaseLaGrangeIncome;

class LaGrangeIncome extends BaseLaGrangeIncome
{
    public function getTaxRate(): float
    {
        return 0.0165;
    }
}