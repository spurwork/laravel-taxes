<?php

namespace Appleton\Taxes\Countries\US\Indiana\DeKalbIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\DeKalbIncome\DeKalbIncome as BaseDeKalbIncome;

class DeKalbIncome extends BaseDeKalbIncome
{
    public function getTaxRate(): float
    {
        return 0.0213;
    }
}