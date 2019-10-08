<?php

namespace Appleton\Taxes\Countries\US\Utah\UtahUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Utah\UtahUnemployment\UtahUnemployment as BaseUtahUnemployment;

class UtahUnemployment extends BaseUtahUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.03;
	const WAGE_BASE = 35300;


    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.utah.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
