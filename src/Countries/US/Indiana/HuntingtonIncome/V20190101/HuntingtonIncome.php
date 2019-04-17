<?php

namespace Appleton\Taxes\Countries\US\Indiana\HuntingtonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\HuntingtonIncome\HuntingtonIncome as BaseHuntingtonIncome;

class HuntingtonIncome extends BaseHuntingtonIncome
{
    public function getTaxRate(): float
    {
        return 0.0195;
    }
}