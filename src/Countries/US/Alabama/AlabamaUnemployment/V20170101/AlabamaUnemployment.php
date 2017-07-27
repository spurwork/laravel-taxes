<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\V20170101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;

class AlabamaUnemployment extends BaseTax
{
    use HasWageBase;

    const TYPE = 'state';
    const WITHHELD = false;

    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 8000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.alabama.unemployment', static::NEW_EMPLOYER_RATE);
        $this->wage_base = static::WAGE_BASE;
    }

    private function getAdjustedEarnings()
    {
        return $this->payroll->earnings < $this->getBaseEarnings() ? $this->payroll->earnings : $this->getBaseEarnings();
    }

    public function compute()
    {
        return round($this->getAdjustedEarnings() * $this->tax_rate, 2);
    }
}
