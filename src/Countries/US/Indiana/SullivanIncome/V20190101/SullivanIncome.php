<?php

namespace Appleton\Taxes\Countries\US\Indiana\SullivanIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\SullivanIncome\SullivanIncome as BaseSullivanIncome;

class SullivanIncome extends BaseSullivanIncome
{
    public function getTaxRate(): float
    {
        return 0.006;
    }
}