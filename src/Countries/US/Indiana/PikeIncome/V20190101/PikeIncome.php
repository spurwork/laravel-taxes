<?php

namespace Appleton\Taxes\Countries\US\Indiana\PikeIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\PikeIncome\PikeIncome as BasePikeIncome;

class PikeIncome extends BasePikeIncome
{
    public function getTaxRate(): float
    {
        return 0.0075;
    }
}