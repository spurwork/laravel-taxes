<?php

namespace Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaUnemployment\NorthCarolinaUnemployment as BaseNorthCarolinaUnemployment;

class NorthCarolinaUnemployment extends BaseNorthCarolinaUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.01;

    const WAGE_BASE = 24300;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.north_carolina.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
