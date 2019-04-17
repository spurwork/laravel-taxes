<?php

namespace Appleton\Taxes\Countries\US\Indiana\RushIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\RushIncome\RushIncome as BaseRushIncome;

class RushIncome extends BaseRushIncome
{
    public function getTaxRate(): float
    {
        return 0.021;
    }
}