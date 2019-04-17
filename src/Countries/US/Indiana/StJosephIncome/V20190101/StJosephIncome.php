<?php

namespace Appleton\Taxes\Countries\US\Indiana\StJosephIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\StJosephIncome\StJosephIncome as BaseStJosephIncome;

class StJosephIncome extends BaseStJosephIncome
{
    public function getTaxRate(): float
    {
        return 0.0175;
    }
}