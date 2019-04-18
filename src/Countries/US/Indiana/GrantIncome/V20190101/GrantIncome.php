<?php

namespace Appleton\Taxes\Countries\US\Indiana\GrantIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\GrantIncome\GrantIncome as BaseGrantIncome;

class GrantIncome extends BaseGrantIncome
{
    public function getTaxRate(): float
    {
        return 0.0255;
    }
}