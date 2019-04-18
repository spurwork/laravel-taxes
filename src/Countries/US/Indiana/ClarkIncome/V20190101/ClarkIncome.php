<?php

namespace Appleton\Taxes\Countries\US\Indiana\ClarkIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\ClarkIncome\ClarkIncome as BaseClarkIncome;

class ClarkIncome extends BaseClarkIncome
{
    public function getTaxRate(): float
    {
        return 0.02;
    }
}