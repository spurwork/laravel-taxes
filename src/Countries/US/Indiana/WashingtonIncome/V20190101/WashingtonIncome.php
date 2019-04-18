<?php

namespace Appleton\Taxes\Countries\US\Indiana\WashingtonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\WashingtonIncome\WashingtonIncome as BaseWashingtonIncome;

class WashingtonIncome extends BaseWashingtonIncome
{
    public function getTaxRate(): float
    {
        return 0.02;
    }
}