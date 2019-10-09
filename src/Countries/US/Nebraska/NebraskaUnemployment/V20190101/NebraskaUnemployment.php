<?php

namespace Appleton\Taxes\Countries\US\Nebraska\NebraskaUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Nebraska\NebraskaUnemployment\NebraskaUnemployment as BaseNebraskaUnemployment;

class NebraskaUnemployment extends BaseNebraskaUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.0125;
    const WAGE_BASE = 9000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.nebraska.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
