<?php

namespace Appleton\Taxes\Countries\US\Indiana\DelawareIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\DelawareIncome\DelawareIncome as BaseDelawareIncome;

class DelawareIncome extends BaseDelawareIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}