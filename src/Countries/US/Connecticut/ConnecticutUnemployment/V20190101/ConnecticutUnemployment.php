<?php

namespace Appleton\Taxes\Countries\US\Connecticut\ConnecticutUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Connecticut\ConnecticutUnemployment\ConnecticutUnemployment as BaseConnecticutUnemployment;

class ConnecticutUnemployment extends BaseConnecticutUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.034;

    const WAGE_BASE = 15000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.connecticut.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
