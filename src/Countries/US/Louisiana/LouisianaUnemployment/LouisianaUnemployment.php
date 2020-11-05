<?php
 namespace Appleton\Taxes\Countries\US\Louisiana\LouisianaUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

class LouisianaUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
    const STATE = 'LA';

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = $payroll->getSutaRate(self::STATE);
    }
}
