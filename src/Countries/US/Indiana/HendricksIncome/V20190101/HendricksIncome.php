<?php

namespace Appleton\Taxes\Countries\US\Indiana\HendricksIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\HendricksIncome\HendricksIncome as BaseHendricksIncome;

class HendricksIncome extends BaseHendricksIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}