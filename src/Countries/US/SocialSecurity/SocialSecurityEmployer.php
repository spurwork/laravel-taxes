<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

abstract class SocialSecurityEmployer extends BaseTax
{
    use HasWageBase;

    public const TYPE = 'federal';
    public const WITHHELD = false;
    public const PRIORITY = 0;

    abstract protected function getTaxRate(): float;

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }

    public function compute(Collection $tax_areas)
    {
        return round($this->getAdjustedEarnings() * $this->getTaxRate(), 2);
    }
}
