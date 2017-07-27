<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment\V20170101;

use Appleton\Taxes\Classes\BaseStateUnemploymentTax;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment as BaseFederalUnemployment;
use Appleton\Taxes\Traits\HasWageBase;

class FederalUnemployment extends BaseFederalUnemployment
{
    use HasWageBase;

    const TYPE = 'federal';
    const WITHHELD = false;

    const TAX_RATE = 0.06;

    const WAGE_BASE = 7000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->state_unemployment_tax_credit = 0.054;
        $this->tax_rate = static::TAX_RATE - $this->state_unemployment_tax_credit;
        $this->wage_base = static::WAGE_BASE;
    }

    public function getAdjustedEarnings()
    {
        return $this->payroll->earnings < $this->getBaseEarnings() ? $this->payroll->earnings : $this->getBaseEarnings();
    }

    public function compute()
    {
        return round($this->getAdjustedEarnings() * $this->tax_rate, 2);
    }
}
