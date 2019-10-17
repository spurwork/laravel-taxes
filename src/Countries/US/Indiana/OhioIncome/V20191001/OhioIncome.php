<?php

namespace Appleton\Taxes\Countries\US\Indiana\OhioIncome\V20191001;

use Appleton\Taxes\Countries\US\Indiana\OhioIncome\OhioIncome as BaseOhioIncome;

class OhioIncome extends BaseOhioIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}
