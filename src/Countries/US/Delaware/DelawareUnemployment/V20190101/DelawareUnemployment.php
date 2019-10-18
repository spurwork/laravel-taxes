<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Delaware\DelawareUnemployment\DelawareUnemployment as BaseDelawareUnemployment;

class DelawareUnemployment extends BaseDelawareUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.015;
    const WAGE_BASE = 16500;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.delaware.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
