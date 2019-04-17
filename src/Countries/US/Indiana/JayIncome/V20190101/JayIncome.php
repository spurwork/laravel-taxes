<?php

namespace Appleton\Taxes\Countries\US\Indiana\JayIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\JayIncome\JayIncome as BaseJayIncome;

class JayIncome extends BaseJayIncome
{
    public function getTaxRate(): float
    {
        return 0.0245;
    }
}