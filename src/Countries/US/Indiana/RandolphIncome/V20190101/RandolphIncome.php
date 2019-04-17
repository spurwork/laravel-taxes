<?php

namespace Appleton\Taxes\Countries\US\Indiana\RandolphIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\RandolphIncome\RandolphIncome as BaseRandolphIncome;

class RandolphIncome extends BaseRandolphIncome
{
    public function getTaxRate(): float
    {
        return 0.0225;
    }
}