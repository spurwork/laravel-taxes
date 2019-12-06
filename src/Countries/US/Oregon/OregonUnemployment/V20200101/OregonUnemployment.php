<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Oregon\OregonUnemployment\OregonUnemployment as BaseOregonUnemployment;

class OregonUnemployment extends BaseOregonUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.024;
    const WAGE_BASE = 42100;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.oregon.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
