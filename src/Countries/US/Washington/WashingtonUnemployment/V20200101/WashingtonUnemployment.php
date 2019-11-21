<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Washington\WashingtonUnemployment\WashingtonUnemployment as BaseWashingtonUnemployment;

class WashingtonUnemployment extends BaseWashingtonUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.015;
    const WAGE_BASE = 52700;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.washington.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
