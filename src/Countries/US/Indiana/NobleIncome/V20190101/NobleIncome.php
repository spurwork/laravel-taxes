<?php

namespace Appleton\Taxes\Countries\US\Indiana\NobleIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\NobleIncome\NobleIncome as BaseNobleIncome;

class NobleIncome extends BaseNobleIncome
{
    public function getTaxRate(): float
    {
        return 0.0175;
    }
}