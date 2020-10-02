<?php

namespace Appleton\Taxes\Countries\US\Montana\MontanaUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Montana\MontanaUnemployment\MontanaUnemployment as BaseMontanaUnemployment;

class MontanaUnemployment extends BaseMontanaUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.0258;
    const WAGE_BASE = 34100;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.montana.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
