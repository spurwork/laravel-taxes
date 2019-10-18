<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsUnemployment\MassachusettsUnemployment as BaseMassachusettsUnemployment;

class MassachusettsUnemployment extends BaseMassachusettsUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.0242;

    const WAGE_BASE = 15000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.massachusetts.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
