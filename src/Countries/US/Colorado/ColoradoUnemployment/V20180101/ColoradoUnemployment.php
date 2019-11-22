<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoUnemployment\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Colorado\ColoradoUnemployment\ColoradoUnemployment as BaseColoradoUnemployment;

class ColoradoUnemployment extends BaseColoradoUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.017;

    const WAGE_BASE = 12600;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.colorado.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
