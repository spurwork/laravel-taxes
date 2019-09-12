<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Washington\WashingtonUnemployment\WashingtonUnemployment as BaseWashingtonUnemployment;

class WashingtonUnemployment extends BaseWashingtonUnemployment
{
    const FUTA_CREDIT = 0.06;
    const NEW_EMPLOYER_RATE = 0.015;
    const WAGE_BASE = 49800;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.washington.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
