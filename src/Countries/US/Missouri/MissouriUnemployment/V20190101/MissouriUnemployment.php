<?php

namespace Appleton\Taxes\Countries\US\Missouri\MissouriUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Missouri\MissouriUnemployment\MissouriUnemployment as BaseMissouriUnemployment;

class MissouriUnemployment extends BaseMissouriUnemployment
{
    const FUTA_CREDIT = 0.06;
    const NEW_EMPLOYER_RATE = 0.027;
    const WAGE_BASE = 12000;


    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.missouri.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
