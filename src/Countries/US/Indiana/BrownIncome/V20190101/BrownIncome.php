<?php

namespace Appleton\Taxes\Countries\US\Indiana\BrownIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\BrownIncome\BrownIncome as BaseBrownIncome;

class BrownIncome extends BaseBrownIncome
{
    public function getTaxRate(): float
    {
        return 0.025234;
    }
}