<?php

namespace Appleton\Taxes\Countries\US\Maine\MaineUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

class MaineUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
    const STATE = 'ME';

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = $payroll->getSutaRate(self::STATE);
    }
}
