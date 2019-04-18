<?php

namespace Appleton\Taxes\Countries\US\Indiana\ParkeIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\ParkeIncome\ParkeIncome as BaseParkeIncome;

class ParkeIncome extends BaseParkeIncome
{
    public function getTaxRate(): float
    {
        return 0.0265;
    }
}