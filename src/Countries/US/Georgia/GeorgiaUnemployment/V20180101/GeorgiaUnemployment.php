<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaUnemployment\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaUnemployment\GeorgiaUnemployment as BaseGeorgiaUnemployment;

class GeorgiaUnemployment extends BaseGeorgiaUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 9500;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.georgia.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
