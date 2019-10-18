<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Michigan\MichiganUnemployment\MichiganUnemployment as BaseMichiganUnemployment;

class MichiganUnemployment extends BaseMichiganUnemployment
{
    const FUTA_CREDIT = 0.054;

    const NEW_EMPLOYER_RATE = 0.027;

    const WAGE_BASE = 9000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.michigan.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
