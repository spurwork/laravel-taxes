<?php

namespace Appleton\Taxes\Countries\US\Indiana\WellsIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\WellsIncome\WellsIncome as BaseWellsIncome;

class WellsIncome extends BaseWellsIncome
{
    public function getTaxRate(): float
    {
        return 0.021;
    }
}