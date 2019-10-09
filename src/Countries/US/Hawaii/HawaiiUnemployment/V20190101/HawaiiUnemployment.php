<?php

namespace Appleton\Taxes\Countries\US\Hawaii\HawaiiUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Hawaii\HawaiiUnemployment\HawaiiUnemployment as BaseHawaiiUnemployment;

class HawaiiUnemployment extends BaseHawaiiUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.024;
    const WAGE_BASE = 46800;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.hawaii.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
