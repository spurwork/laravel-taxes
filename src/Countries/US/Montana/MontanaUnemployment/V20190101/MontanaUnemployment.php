<?php

namespace Appleton\Taxes\Countries\US\Montana\MontanaUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Montana\MontanaUnemployment\MontanaUnemployment as BaseMontanaUnemployment;

class MontanaUnemployment extends BaseMontanaUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.0258;
    const WAGE_BASE = 33000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.montana.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
