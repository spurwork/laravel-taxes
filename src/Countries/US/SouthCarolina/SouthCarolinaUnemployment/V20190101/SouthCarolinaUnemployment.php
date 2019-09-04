<?php

namespace Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaUnemployment\SouthCarolinaUnemployment as BaseSouthCarolinaUnemployment;

class SouthCarolinaUnemployment extends BaseSouthCarolinaUnemployment
{
    const FUTA_CREDIT = 0.06;
    const NEW_EMPLOYER_RATE = 0.0087;
    const WAGE_BASE = 14000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.south_carolina.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
