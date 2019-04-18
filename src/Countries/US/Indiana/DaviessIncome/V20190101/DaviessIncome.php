<?php

namespace Appleton\Taxes\Countries\US\Indiana\DaviessIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\DaviessIncome\DaviessIncome as BaseDaviessIncome;

class DaviessIncome extends BaseDaviessIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}