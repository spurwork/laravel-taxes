<?php

namespace Appleton\Taxes\Countries\US\Indiana\JohnsonIncome\V20191001;

use Appleton\Taxes\Countries\US\Indiana\JohnsonIncome\JohnsonIncome as BaseJohnsonIncome;

class JohnsonIncome extends BaseJohnsonIncome
{
    public function getTaxRate(): float
    {
        return 0.012;
    }
}
