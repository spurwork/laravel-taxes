<?php

namespace Appleton\Taxes\Countries\US\Indiana\CarrollIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\CarrollIncome\CarrollIncome as BaseCarrollIncome;

class CarrollIncome extends BaseCarrollIncome
{
    public function getTaxRate(): float
    {
        return 0.022733;
    }
}