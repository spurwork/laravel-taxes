<?php

namespace Appleton\Taxes\Countries\US\Indiana\FloydIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\FloydIncome\FloydIncome as BaseFloydIncome;

class FloydIncome extends BaseFloydIncome
{
    public function getTaxRate(): float
    {
        return 0.0135;
    }
}