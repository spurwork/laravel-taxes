<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

abstract class SocialSecurity extends BaseTax
{
    use HasWageBase;

    public const TYPE = 'federal';
    public const WITHHELD = true;
    public const PRIORITY = 0;

    abstract protected function getTaxRate(): float;

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getAdjustedEarnings() * $this->getTaxRate());
        return round($this->tax_total, 2);
    }
}
