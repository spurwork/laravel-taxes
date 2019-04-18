<?php

namespace Appleton\Taxes\Countries\US\Indiana\MarionIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\MarionIncome\MarionIncome as BaseMarionIncome;

class MarionIncome extends BaseMarionIncome
{
    public function getTaxRate(): float
    {
        return 0.0202;
    }
}