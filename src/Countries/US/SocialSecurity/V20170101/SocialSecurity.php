<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20170101;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Traits\HasWageBase;

class SocialSecurity extends BaseTax
{
    use HasWageBase;

    const TYPE = 'federal';
    const WITHHELD = true;

    const TAX_RATE = 0.062;
    const WAGE_BASE = 127200;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->wage_base = static::WAGE_BASE;
    }

    public function getAdjustedEarnings()
    {
        return $this->payroll->earnings < $this->getBaseEarnings() ? $this->payroll->earnings : $this->getBaseEarnings();
    }

    public function compute()
    {
        return round($this->getAdjustedEarnings() * static::TAX_RATE, 2);
    }
}
