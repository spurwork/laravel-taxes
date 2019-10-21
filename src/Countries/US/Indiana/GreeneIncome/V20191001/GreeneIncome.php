<?php

namespace Appleton\Taxes\Countries\US\Indiana\GreeneIncome\V20191001;

use Appleton\Taxes\Countries\US\Indiana\GreeneIncome\GreeneIncome as BaseGreeneIncome;

class GreeneIncome extends BaseGreeneIncome
{
    public function getTaxRate(): float
    {
        return 0.0195;
    }
}
