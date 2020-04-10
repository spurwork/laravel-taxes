<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment\V20170101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\StateUnemployment;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment as BaseFederalUnemployment;

class FederalUnemployment extends BaseFederalUnemployment
{
    const TAX_RATE = 0.06;

    const WAGE_BASE = 7000;

    public function __construct(Payroll $payroll, StateUnemployment $state_unemployment)
    {
        parent::__construct($payroll);
        $this->tax_rate = static::TAX_RATE - $state_unemployment->getTaxCredit();
    }

    protected function getTaxRate(): float
    {
        return $this->tax_rate;
    }
}
