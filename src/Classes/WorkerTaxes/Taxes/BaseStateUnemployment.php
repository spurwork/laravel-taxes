<?php

namespace Appleton\Taxes\Classes\WorkerTaxes\Taxes;

use Appleton\Taxes\Traits\HasWageBase;

class BaseStateUnemployment extends BaseTax implements StateUnemployment
{
    use HasWageBase;

    public function getTaxCredit()
    {
        return defined('static::FUTA_CREDIT') ? static::FUTA_CREDIT : 0;
    }

    protected function getTaxRate(): float
    {
        return $this->payroll->getSutaRate(static::STATE);
    }
}
