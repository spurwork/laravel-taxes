<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinUnemployment\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Wisconsin\WisconsinUnemployment\WisconsinUnemployment as BaseWisconsinUnemployment;

class WisconsinUnemployment extends BaseWisconsinUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.0305;
    // Greater than 500k 3.25%

    const WAGE_BASE = 14000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.wisconsin.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
