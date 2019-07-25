<?php
namespace Appleton\Taxes\Countries\US\Ohio\OhioUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Ohio\OhioUnemployment\OhioUnemployment as BaseOhioUnemployment;

class OhioUnemployment extends BaseOhioUnemployment
{
    const FUTA_CREDIT = 0.06;
    const NEW_EMPLOYER_RATE = 0.03689;
    const WAGE_BASE = 10000;
    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.ohio.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
