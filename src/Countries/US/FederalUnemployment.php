<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

class FederalUnemployment extends BaseTax
{
    use HasWageBase;

    const TAX_RATE = 0.06;
    const WAGE_BASE = 7000;
    
    private function getTaxRate()
    {
        return $this->credit() ? self::TAX_RATE - $this->credit() : self::TAX_RATE;
    }

    public function compute()
    {
        return round($this->getAdjustedEarnings() * $this->getTaxRate(), 2);
    }
}
