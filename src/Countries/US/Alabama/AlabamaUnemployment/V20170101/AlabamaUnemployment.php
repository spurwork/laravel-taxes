<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\V20170101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment as BaseAlabamaUnemployment;

class AlabamaUnemployment extends BaseAlabamaUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 8000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.alabama.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
