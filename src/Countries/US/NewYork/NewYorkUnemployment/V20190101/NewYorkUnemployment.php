<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\NewYork\NewYorkUnemployment\NewYorkUnemployment as BaseNewYorkUnemployment;

class NewYorkUnemployment extends BaseNewYorkUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.036;

    const WAGE_BASE = 11400;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.new_york.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
