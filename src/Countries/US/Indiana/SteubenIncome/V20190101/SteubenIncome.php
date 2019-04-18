<?php

namespace Appleton\Taxes\Countries\US\Indiana\SteubenIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\SteubenIncome\SteubenIncome as BaseSteubenIncome;

class SteubenIncome extends BaseSteubenIncome
{
    public function getTaxRate(): float
    {
        return 0.0179;
    }
}