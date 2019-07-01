<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Colorado\ColoradoUnemployment\ColoradoUnemployment as BaseColoradoUnemployment;

class ColoradoUnemployment extends BaseColoradoUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.017;

    const WAGE_BASE = 13100;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.colorado.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
