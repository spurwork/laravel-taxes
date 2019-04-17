<?php

namespace Appleton\Taxes\Countries\US\Indiana\OwenIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\OwenIncome\OwenIncome as BaseOwenIncome;

class OwenIncome extends BaseOwenIncome
{
    public function getTaxRate(): float
    {
        return 0.013;
    }
}