<?php

namespace Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaUnemployment\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaUnemployment\NorthDakotaUnemployment as BaseNorthDakotaUnemployment;

class NorthDakotaUnemployment extends BaseNorthDakotaUnemployment
{
    const FUTA_CREDIT = 0.054;
    const NEW_EMPLOYER_RATE = 0.0121;
    const WAGE_BASE = 36400;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.north_dakota.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
