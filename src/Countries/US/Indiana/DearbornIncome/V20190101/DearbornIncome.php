<?php

namespace Appleton\Taxes\Countries\US\Indiana\DearbornIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\DearbornIncome\DearbornIncome as BaseDearbornIncome;

class DearbornIncome extends BaseDearbornIncome
{
    public function getTaxRate(): float
    {
        return 0.012;
    }
}