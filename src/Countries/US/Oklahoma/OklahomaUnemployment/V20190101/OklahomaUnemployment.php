<?php

namespace Appleton\Taxes\Countries\US\Oklahoma\OklahomaUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Oklahoma\OklahomaUnemployment\OklahomaUnemployment as BaseOklahomaUnemployment;

class OklahomaUnemployment extends BaseOklahomaUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.015;

    const WAGE_BASE = 18100;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.oklahoma.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
