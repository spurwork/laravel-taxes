<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;
use Appleton\Taxes\Traits\WithCredit;
use Appleton\Taxes\Traits\WithYtdEarnings;

class FederalUnemployment extends BaseTax
{
    use HasWageBase, WithCredit, WithYtdEarnings;

    const TYPE = 'federal';
    const WITHHELD = false;

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
