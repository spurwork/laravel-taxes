<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;
use Appleton\Taxes\Traits\WithTaxRate;
use Appleton\Taxes\Traits\WithYtdEarnings;

class AlabamaUnemployment extends BaseTax
{
    use HasWageBase, WithTaxRate, WithYtdEarnings;

    const TYPE = 'state';
    const WITHHELD = false;

    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 8000;

    private function getTaxRate()
    {
        return $this->taxRate() ? $this->taxRate() : self::NEW_EMPLOYER_RATE;
    }

    public function compute()
    {
        return round($this->getAdjustedEarnings() * $this->getTaxRate(), 2);
    }
}
