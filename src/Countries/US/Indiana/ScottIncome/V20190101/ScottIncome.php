<?php

namespace Appleton\Taxes\Countries\US\Indiana\ScottIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\ScottIncome\ScottIncome as BaseScottIncome;

class ScottIncome extends BaseScottIncome
{
    public function getTaxRate(): float
    {
        return 0.0216;
    }
}