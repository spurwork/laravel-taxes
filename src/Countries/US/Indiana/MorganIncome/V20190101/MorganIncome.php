<?php

namespace Appleton\Taxes\Countries\US\Indiana\MorganIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\MorganIncome\MorganIncome as BaseMorganIncome;

class MorganIncome extends BaseMorganIncome
{
    public function getTaxRate(): float
    {
        return 0.0272;
    }
}