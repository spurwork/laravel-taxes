<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment\NewMexicoUnemployment as BaseNewMexicoUnemployment;

class NewMexicoUnemployment extends BaseNewMexicoUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.01;

    const WAGE_BASE = 24200;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.new_mexico.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
