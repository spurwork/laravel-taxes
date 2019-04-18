<?php

namespace Appleton\Taxes\Countries\US\Indiana\LaPorteIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\LaPorteIncome\LaPorteIncome as BaseLaPorteIncome;

class LaPorteIncome extends BaseLaPorteIncome
{
    public function getTaxRate(): float
    {
        return 0.0095;
    }
}