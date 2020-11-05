<?php

namespace Appleton\Taxes\Countries\US\Virginia\VirginiaUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

abstract class VirginiaUnemployment extends BaseStateUnemployment
{
    public const TYPE = 'state';
    public const WITHHELD = false;
    const STATE = 'VA';

    public function __construct(Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_rate = $payroll->getSutaRate(self::STATE);
    }
}
