<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensationEmployer\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Washington\WashingtonWorkersCompensationEmployer\WashingtonWorkersCompensationEmployer as BaseWashingtonWorkersCompensationEmployer;

class WashingtonWorkersCompensationEmployer extends BaseWashingtonWorkersCompensationEmployer
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
