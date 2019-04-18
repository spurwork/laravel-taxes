<?php

namespace Appleton\Taxes\Countries\US\Indiana\ShelbyIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\ShelbyIncome\ShelbyIncome as BaseShelbyIncome;

class ShelbyIncome extends BaseShelbyIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}