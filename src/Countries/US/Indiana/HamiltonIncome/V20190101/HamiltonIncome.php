<?php

namespace Appleton\Taxes\Countries\US\Indiana\HamiltonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\HamiltonIncome\HamiltonIncome as BaseHamiltonIncome;

class HamiltonIncome extends BaseHamiltonIncome
{
    public function getTaxRate(): float
    {
        return 0.01;
    }
}