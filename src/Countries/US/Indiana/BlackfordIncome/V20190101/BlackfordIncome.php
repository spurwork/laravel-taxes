<?php

namespace Appleton\Taxes\Countries\US\Indiana\BlackfordIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\BlackfordIncome\BlackfordIncome as BaseBlackfordIncome;

class BlackfordIncome extends BaseBlackfordIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}