<?php

namespace Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemployment\NewJerseyUnemployment as BaseNewJerseyUnemployment;

class NewJerseyUnemployment extends BaseNewJerseyUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 7000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.new_jersey.unemployment', static::NEW_EMPLOYER_RATE);
    }
}