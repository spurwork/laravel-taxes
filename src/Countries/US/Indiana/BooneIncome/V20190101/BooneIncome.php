<?php

namespace Appleton\Taxes\Countries\US\Indiana\BooneIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\BooneIncome\BooneIncome as BaseBooneIncome;

class BooneIncome extends BaseBooneIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}