<?php

namespace Appleton\Taxes\Countries\US\Indiana\WayneIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\WayneIncome\WayneIncome as BaseWayneIncome;

class WayneIncome extends BaseWayneIncome
{
    public function getTaxRate(): float
    {
        return 0.015;
    }
}