<?php

namespace Appleton\Taxes\Countries\US\Indiana\CassIncome\V20200101;

use Appleton\Taxes\Countries\US\Indiana\CassIncome\CassIncome as BaseCassIncome;

class CassIncome extends BaseCassIncome
{
    public function getTaxRate(): float
    {
        return 0.027;
    }
}
