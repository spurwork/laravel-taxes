<?php

namespace Appleton\Taxes\Countries\US\Indiana\MontgomeryIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\MontgomeryIncome\MontgomeryIncome as BaseMontgomeryIncome;

class MontgomeryIncome extends BaseMontgomeryIncome
{
    public function getTaxRate(): float
    {
        return 0.023;
    }
}