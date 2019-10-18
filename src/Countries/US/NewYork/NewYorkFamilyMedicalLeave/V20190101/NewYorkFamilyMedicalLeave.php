<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave\V20190101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave\NewYorkFamilyMedicalLeave as BaseNewYorkFamilyMedicalLeave;
use Illuminate\Database\Eloquent\Collection;

class NewYorkFamilyMedicalLeave extends BaseNewYorkFamilyMedicalLeave
{
    const TAX_RATE = 0.00153;
    const WAGE_BASE = 1357.11;

    public function getBaseEarnings()
    {
        return min(self::WAGE_BASE, $this->payroll->getEarnings());
    }

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
