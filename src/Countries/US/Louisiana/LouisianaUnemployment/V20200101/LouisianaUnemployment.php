<?php

namespace Appleton\Taxes\Countries\US\Louisiana\LouisianaUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Louisiana\LouisianaUnemployment\LouisianaUnemployment as BaseLouisianaUnemployment;

class LouisianaUnemployment extends BaseLouisianaUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.03;
    const WAGE_BASE = 7700;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.louisiana.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
