<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class AlabamaUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
    const STATE = 'AL';

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = $payroll->getSutaRate(self::STATE);
    }
}
