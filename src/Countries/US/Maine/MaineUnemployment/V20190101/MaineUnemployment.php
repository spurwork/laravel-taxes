<?php

namespace Appleton\Taxes\Countries\US\Maine\MaineUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Maine\MaineUnemployment\MaineUnemployment as BaseMaineUnemployment;

class MaineUnemployment extends BaseMaineUnemployment
{
    const FUTA_CREDIT = 0.06;
    const NEW_EMPLOYER_RATE = 0.0189;
    const WAGE_BASE = 12000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.maine.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
