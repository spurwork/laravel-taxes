<?php

namespace Appleton\Taxes\Countries\US\Indiana\PorterIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\PorterIncome\PorterIncome as BasePorterIncome;

class PorterIncome extends BasePorterIncome
{
    public function getTaxRate(): float
    {
        return 0.005;
    }
}