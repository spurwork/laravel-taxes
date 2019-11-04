<?php

namespace Appleton\Taxes\Countries\US\Florida\FloridaUnemployment\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Florida\FloridaUnemployment\FloridaUnemployment as BaseFloridaUnemployment;

class FloridaUnemployment extends BaseFloridaUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 7000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.florida.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
