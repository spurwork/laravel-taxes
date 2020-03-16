<?php

namespace Appleton\Taxes\Countries\US\Indiana\DecaturIncome\V20200101;

use Appleton\Taxes\Countries\US\Indiana\DecaturIncome\DecaturIncome as BaseDecaturIncome;

class DecaturIncome extends BaseDecaturIncome
{
    public function getTaxRate(): float
    {
        return 0.025;
    }
}
