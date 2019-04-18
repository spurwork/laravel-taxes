<?php

namespace Appleton\Taxes\Countries\US\Indiana\ClayIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\ClayIncome\ClayIncome as BaseClayIncome;

class ClayIncome extends BaseClayIncome
{
    public function getTaxRate(): float
    {
        return 0.0225;
    }
}