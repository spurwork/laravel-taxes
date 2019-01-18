<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

class BaseStateUnemployment extends BaseTax implements StateUnemployment
{
    use HasWageBase;

    public function compute()
    {
        return round($this->getAdjustedEarnings() * $this->tax_rate, 2);
    }

    public function getAdjustedEarnings()
    {
        return min($this->payroll->earnings, $this->getBaseEarnings());
    }

    public function getTaxCredit() {
        return defined('static::FUTA_CREDIT') ? static::FUTA_CREDIT : 0;
    }
}
