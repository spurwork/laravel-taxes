<?php

namespace Appleton\Taxes\Countries\US\Indiana\PulaskiIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\PulaskiIncome\PulaskiIncome as BasePulaskiIncome;

class PulaskiIncome extends BasePulaskiIncome
{
    public function getTaxRate(): float
    {
        return 0.0338;
    }
}