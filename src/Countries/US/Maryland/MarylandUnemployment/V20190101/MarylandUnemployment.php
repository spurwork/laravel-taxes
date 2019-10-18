<?php

namespace Appleton\Taxes\Countries\US\Maryland\MarylandUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Maryland\MarylandUnemployment\MarylandUnemployment as BaseMarylandUnemployment;

class MarylandUnemployment extends BaseMarylandUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.026;

    const WAGE_BASE = 8500;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.maryland.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
