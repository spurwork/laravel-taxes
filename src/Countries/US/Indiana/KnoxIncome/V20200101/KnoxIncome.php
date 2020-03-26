<?php

namespace Appleton\Taxes\Countries\US\Indiana\KnoxIncome\V20200101;

use Appleton\Taxes\Countries\US\Indiana\KnoxIncome\KnoxIncome as BaseKnoxIncome;

class KnoxIncome extends BaseKnoxIncome
{
    public function getTaxRate(): float
    {
        return 0.012;
    }
}
