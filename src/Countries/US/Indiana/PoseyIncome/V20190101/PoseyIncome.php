<?php

namespace Appleton\Taxes\Countries\US\Indiana\PoseyIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\PoseyIncome\PoseyIncome as BasePoseyIncome;

class PoseyIncome extends BasePoseyIncome
{
    public function getTaxRate(): float
    {
        return 0.0125;
    }
}