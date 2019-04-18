<?php

namespace Appleton\Taxes\Countries\US\Indiana\PerryIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\PerryIncome\PerryIncome as BasePerryIncome;

class PerryIncome extends BasePerryIncome
{
    public function getTaxRate(): float
    {
        return 0.0181;
    }
}