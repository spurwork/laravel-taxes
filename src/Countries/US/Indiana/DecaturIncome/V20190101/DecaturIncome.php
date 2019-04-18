<?php

namespace Appleton\Taxes\Countries\US\Indiana\DecaturIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\DecaturIncome\DecaturIncome as BaseDecaturIncome;

class DecaturIncome extends BaseDecaturIncome
{
    public function getTaxRate(): float
    {
        return 0.0235;
    }
}