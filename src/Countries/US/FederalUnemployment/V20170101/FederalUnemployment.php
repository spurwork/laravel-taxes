<?php

namespace Appleton\Taxes\Countries\US\FederalUnemployment\V20170101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\StateUnemployment;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment as BaseFederalUnemployment;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class FederalUnemployment extends BaseFederalUnemployment
{
    use HasWageBase;

    const TAX_RATE = 0.06;

    const WAGE_BASE = 7000;

    public function __construct(Payroll $payroll, StateUnemployment $state_unemployment)
    {
        parent::__construct($payroll);
        $this->tax_rate = static::TAX_RATE - $state_unemployment->getTaxCredit();
    }

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }

    public function compute(Collection $tax_areas)
    {
        return round($this->getAdjustedEarnings() * $this->tax_rate, 2);
    }
}
