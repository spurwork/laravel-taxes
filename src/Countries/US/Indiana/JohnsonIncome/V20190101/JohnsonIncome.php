<?php

namespace Appleton\Taxes\Countries\US\Indiana\JohnsonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\JohnsonIncome\JohnsonIncome as BaseJohnsonIncome;

class JohnsonIncome extends BaseJohnsonIncome
{
    public function getTaxRate(): float
    {
        return 0.01;
    }
}