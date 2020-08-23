<?php

namespace Appleton\Taxes\Countries\US\Utah\UtahUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Utah\UtahUnemployment\UtahUnemployment as BaseUtahUnemployment;

class UtahUnemployment extends BaseUtahUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.011;
    const WAGE_BASE = 36600;


    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.utah.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
