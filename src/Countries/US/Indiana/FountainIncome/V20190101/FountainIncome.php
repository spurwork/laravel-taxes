<?php

namespace Appleton\Taxes\Countries\US\Indiana\FountainIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\FountainIncome\FountainIncome as BaseFountainIncome;

class FountainIncome extends BaseFountainIncome
{
    public function getTaxRate(): float
    {
        return 0.021;
    }
}