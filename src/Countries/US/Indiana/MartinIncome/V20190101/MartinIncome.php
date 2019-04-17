<?php

namespace Appleton\Taxes\Countries\US\Indiana\MartinIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\MartinIncome\MartinIncome as BaseMartinIncome;

class MartinIncome extends BaseMartinIncome
{
    public function getTaxRate(): float
    {
        return 0.0175;
    }
}