<?php

namespace Appleton\Taxes\Countries\US\Indiana\WarrenIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\WarrenIncome\WarrenIncome as BaseWarrenIncome;

class WarrenIncome extends BaseWarrenIncome
{
    public function getTaxRate(): float
    {
        return 0.0212;
    }
}