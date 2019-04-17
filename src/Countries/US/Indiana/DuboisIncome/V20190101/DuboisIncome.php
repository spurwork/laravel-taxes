<?php

namespace Appleton\Taxes\Countries\US\Indiana\DuboisIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\DuboisIncome\DuboisIncome as BaseDuboisIncome;

class DuboisIncome extends BaseDuboisIncome
{
    public function getTaxRate(): float
    {
        return 0.01;
    }
}