<?php

namespace Appleton\Taxes\Countries\US\Indiana\HarrisonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\HarrisonIncome\HarrisonIncome as BaseHarrisonIncome;

class HarrisonIncome extends BaseHarrisonIncome
{
    public function getTaxRate(): float
    {
        return 0.01;
    }
}