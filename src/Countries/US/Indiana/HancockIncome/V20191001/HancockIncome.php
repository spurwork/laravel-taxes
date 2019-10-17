<?php

namespace Appleton\Taxes\Countries\US\Indiana\HancockIncome\V20191001;

use Appleton\Taxes\Countries\US\Indiana\HancockIncome\HancockIncome as BaseHancockIncome;

class HancockIncome extends BaseHancockIncome
{
    public function getTaxRate(): float
    {
        return 0.0194;
    }
}
