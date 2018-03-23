<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaUnemployment\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment as BaseAlabamaUnemployment;
use Appleton\Taxes\Traits\HasWageBase;

class GeorgiaUnemployment extends BaseAlabamaUnemployment
{
    use HasWageBase;

    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 9500;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.georgia.unemployment', static::NEW_EMPLOYER_RATE);
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
