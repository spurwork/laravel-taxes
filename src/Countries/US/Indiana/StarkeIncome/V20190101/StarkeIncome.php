<?php

namespace Appleton\Taxes\Countries\US\Indiana\StarkeIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\StarkeIncome\StarkeIncome as BaseStarkeIncome;

class StarkeIncome extends BaseStarkeIncome
{
    public function getTaxRate(): float
    {
        return 0.0171;
    }
}