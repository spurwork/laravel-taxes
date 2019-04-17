<?php

namespace Appleton\Taxes\Countries\US\Indiana\WarrickIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\WarrickIncome\WarrickIncome as BaseWarrickIncome;

class WarrickIncome extends BaseWarrickIncome
{
    public function getTaxRate(): float
    {
        return 0.005;
    }
}