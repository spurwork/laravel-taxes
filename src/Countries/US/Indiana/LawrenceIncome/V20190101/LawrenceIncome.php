<?php

namespace Appleton\Taxes\Countries\US\Indiana\LawrenceIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\LawrenceIncome\LawrenceIncome as BaseLawrenceIncome;

class LawrenceIncome extends BaseLawrenceIncome
{
    public function getTaxRate(): float
    {
        return 0.0175;
    }
}