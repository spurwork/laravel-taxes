<?php

namespace Appleton\Taxes\Countries\US\Indiana\GibsonIncome\V20200101;

use Appleton\Taxes\Countries\US\Indiana\GibsonIncome\GibsonIncome as BaseGibsonIncome;

class GibsonIncome extends BaseGibsonIncome
{
    public function getTaxRate(): float
    {
        return 0.009;
    }
}
