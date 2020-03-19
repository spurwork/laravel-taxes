<?php

namespace Appleton\Taxes\Countries\US\Minnesota\MinnesotaUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Minnesota\MinnesotaUnemployment\MinnesotaUnemployment as BaseMinnesotaUnemployment;

class MinnesotaUnemployment extends BaseMinnesotaUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.01;
    const WAGE_BASE = 35000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.minnesota.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
