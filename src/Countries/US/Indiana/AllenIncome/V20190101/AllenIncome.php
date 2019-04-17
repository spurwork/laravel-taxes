<?php

namespace Appleton\Taxes\Countries\US\Indiana\AllenIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\AllenIncome\AllenIncome as BaseAllenIncome;

class AllenIncome extends BaseAllenIncome
{
    public function getTaxRate(): float
    {
        return 0.0148;
    }
}