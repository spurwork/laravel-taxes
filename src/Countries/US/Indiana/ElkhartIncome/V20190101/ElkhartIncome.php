<?php

namespace Appleton\Taxes\Countries\US\Indiana\ElkhartIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\ElkhartIncome\ElkhartIncome as BaseElkhartIncome;

class ElkhartIncome extends BaseElkhartIncome
{
    public function getTaxRate(): float
    {
        return 0.02;
    }
}