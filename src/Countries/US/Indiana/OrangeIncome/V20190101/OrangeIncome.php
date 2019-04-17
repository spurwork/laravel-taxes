<?php

namespace Appleton\Taxes\Countries\US\Indiana\OrangeIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\OrangeIncome\OrangeIncome as BaseOrangeIncome;

class OrangeIncome extends BaseOrangeIncome
{
    public function getTaxRate(): float
    {
        return 0.0175;
    }
}