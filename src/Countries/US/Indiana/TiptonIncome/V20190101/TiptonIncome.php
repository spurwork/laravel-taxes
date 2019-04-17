<?php

namespace Appleton\Taxes\Countries\US\Indiana\TiptonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\TiptonIncome\TiptonIncome as BaseTiptonIncome;

class TiptonIncome extends BaseTiptonIncome
{
    public function getTaxRate(): float
    {
        return 0.026;
    }
}