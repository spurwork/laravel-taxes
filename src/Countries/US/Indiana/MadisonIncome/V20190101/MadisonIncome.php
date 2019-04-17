<?php

namespace Appleton\Taxes\Countries\US\Indiana\MadisonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\MadisonIncome\MadisonIncome as BaseMadisonIncome;

class MadisonIncome extends BaseMadisonIncome
{
    public function getTaxRate(): float
    {
        return 0.0175;
    }
}