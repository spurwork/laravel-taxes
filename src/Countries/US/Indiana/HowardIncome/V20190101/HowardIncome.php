<?php

namespace Appleton\Taxes\Countries\US\Indiana\HowardIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\HowardIncome\HowardIncome as BaseHowardIncome;

class HowardIncome extends BaseHowardIncome
{
    public function getTaxRate(): float
    {
        return 0.0175;
    }
}