<?php

namespace Appleton\Taxes\Countries\US\Iowa\IowaUnemployment\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Iowa\IowaUnemployment\IowaUnemployment as BaseIowaUnemployment;

class IowaUnemployment extends BaseIowaUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.01;
    const WAGE_BASE = 31600;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.iowa.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
