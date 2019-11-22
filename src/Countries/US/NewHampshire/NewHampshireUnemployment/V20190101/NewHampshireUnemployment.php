<?php

namespace Appleton\Taxes\Countries\US\NewHampshire\NewHampshireUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\NewHampshire\NewHampshireUnemployment\NewHampshireUnemployment as BaseNewHampshireUnemployment;

class NewHampshireUnemployment extends BaseNewHampshireUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.012;
    const WAGE_BASE = 14000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.new_hampshire.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
