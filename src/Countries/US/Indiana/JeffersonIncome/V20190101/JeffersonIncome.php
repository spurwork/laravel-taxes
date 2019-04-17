<?php

namespace Appleton\Taxes\Countries\US\Indiana\JeffersonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\JeffersonIncome\JeffersonIncome as BaseJeffersonIncome;

class JeffersonIncome extends BaseJeffersonIncome
{
    public function getTaxRate(): float
    {
        return 0.0035;
    }
}