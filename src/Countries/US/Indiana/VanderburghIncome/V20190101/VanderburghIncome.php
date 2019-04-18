<?php

namespace Appleton\Taxes\Countries\US\Indiana\VanderburghIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\VanderburghIncome\VanderburghIncome as BaseVanderburghIncome;

class VanderburghIncome extends BaseVanderburghIncome
{
    public function getTaxRate(): float
    {
        return 0.012;
    }
}