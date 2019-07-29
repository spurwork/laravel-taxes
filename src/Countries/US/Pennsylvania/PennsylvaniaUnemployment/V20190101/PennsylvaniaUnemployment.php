<?php
namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaUnemployment\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaUnemployment\PennsylvaniaUnemployment as BasePennsylvaniaUnemployment;

class PennsylvaniaUnemployment extends BasePennsylvaniaUnemployment
{
    const FUTA_CREDIT = 0.06;
    const NEW_EMPLOYER_RATE = 0.03689;
    const WAGE_BASE = 10000;

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = config('taxes.rates.us.pennsylvania.unemployment', static::NEW_EMPLOYER_RATE);
    }
}
