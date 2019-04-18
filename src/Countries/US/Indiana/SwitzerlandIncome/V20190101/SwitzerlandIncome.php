<?php

namespace Appleton\Taxes\Countries\US\Indiana\SwitzerlandIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\SwitzerlandIncome\SwitzerlandIncome as BaseSwitzerlandIncome;

class SwitzerlandIncome extends BaseSwitzerlandIncome
{
    public function getTaxRate(): float
    {
        return 0.01;
    }
}