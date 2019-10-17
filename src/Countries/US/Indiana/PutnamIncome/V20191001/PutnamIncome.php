<?php

namespace Appleton\Taxes\Countries\US\Indiana\PutnamIncome\V20191001;

use Appleton\Taxes\Countries\US\Indiana\PutnamIncome\PutnamIncome as BasePutnamIncome;

class PutnamIncome extends BasePutnamIncome
{
    public function getTaxRate(): float
    {
        return 0.021;
    }
}
