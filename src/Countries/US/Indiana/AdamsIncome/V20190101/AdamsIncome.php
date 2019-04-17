<?php

namespace Appleton\Taxes\Countries\US\Indiana\AdamsIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\AdamsIncome\AdamsIncome as BaseAdamsIncome;

class AdamsIncome extends BaseAdamsIncome
{
    public function getTaxRate(): float
    {
        return 0.01624;
    }
}