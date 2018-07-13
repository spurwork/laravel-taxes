<?php

namespace Appleton\Taxes\Countries\US\Texas\TexasUnemployment\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Texas\TexasUnemployment\TexasUnemployment as BaseTexasUnemployment;

class TexasUnemployment extends BaseTexasUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 9000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.texas.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
