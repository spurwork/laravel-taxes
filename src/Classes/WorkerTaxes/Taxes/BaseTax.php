<?php

namespace Appleton\Taxes\Classes\WorkerTaxes\Taxes;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseTax
{
    public const SCOPE = 'worker';
    public const PRIORITY = 9999;

    public $tax_total = 0;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }

    public function getAdjustedEarnings()
    {
        return $this->payroll->getEarnings();
    }

    public function getAmount()
    {
        return $this->tax_total;
    }

    public function getEarnings()
    {
        return method_exists($this, 'getBaseEarnings') ? $this->getBaseEarnings() : $this->payroll->getEarnings();
    }

    public function doesApply(Collection $tax_areas): bool
    {
        return true;
    }
}
