<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsUnemployment\MassachusettsUnemployment as BaseMassachusettsUnemployment;

class MassachusettsUnemployment extends BaseMassachusettsUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.01;

    const WAGE_BASE = 24200;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.new_mexico.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
