<?php

namespace Appleton\Taxes\Countries\US\Arizona\ArizonaUnemployment\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Arizona\ArizonaUnemployment\ArizonaUnemployment as BaseArizonaUnemployment;

class ArizonaUnemployment extends BaseArizonaUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.02;

    const WAGE_BASE = 7000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.arizona.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
