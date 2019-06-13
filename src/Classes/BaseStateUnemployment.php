<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class BaseStateUnemployment extends BaseTax implements StateUnemployment
{
    use HasWageBase;

    public function compute(Collection $tax_areas)
    {
        dump($this->tax_rate);
        return round($this->getAdjustedEarnings() * $this->tax_rate, 2);
    }

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }

    public function getTaxCredit()
    {
        return defined('static::FUTA_CREDIT') ? static::FUTA_CREDIT : 0;
    }
}
