<?php

namespace Appleton\Taxes\Countries\US\Ohio\OhioUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Ohio\OhioUnemployment\OhioUnemployment as BaseOhioUnemployment;

class OhioUnemployment extends BaseOhioUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 9000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.ohio.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
