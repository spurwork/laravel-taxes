<?php

namespace Appleton\Taxes\Countries\US\SocialSecurity\V20170101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity as BaseSocialSecurity;
use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class SocialSecurity extends BaseSocialSecurity
{
    use HasWageBase;

    const TAX_RATE = 0.062;
    const WAGE_BASE = 127200;

    public function getAdjustedEarnings()
    {
        return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    }

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getAdjustedEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
