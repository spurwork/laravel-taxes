<?php

namespace Appleton\Taxes\Countries\US\Minnesota\MinnesotaUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Minnesota\MinnesotaUnemployment\MinnesotaUnemployment as BaseMinnesotaUnemployment;

class MinnesotaUnemployment extends BaseMinnesotaUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.01;
    const WAGE_BASE = 34600;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.minnesota.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
