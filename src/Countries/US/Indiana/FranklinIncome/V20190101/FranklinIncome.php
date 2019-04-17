<?php

namespace Appleton\Taxes\Countries\US\Indiana\FranklinIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\FranklinIncome\FranklinIncome as BaseFranklinIncome;

class FranklinIncome extends BaseFranklinIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}