<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensation\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensation\WashingtonWorkersCompensation as BaseWashingtonWorkersCompensation;

class WashingtonWorkersCompensation extends BaseWashingtonWorkersCompensation
{
    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
    }

    protected function getTaxRate($rate): float
    {
        return $rate->employee_rate;
    }
}
