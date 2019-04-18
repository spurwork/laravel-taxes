<?php

namespace Appleton\Taxes\Countries\US\Indiana\BentonIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\BentonIncome\BentonIncome as BaseBentonIncome;

class BentonIncome extends BaseBentonIncome
{
    public function getTaxRate(): float
    {
        return 0.0179;
    }
}