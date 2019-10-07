<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeave\V20190101;

use Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeave\WashingtonFamilyMedicalLeave as BaseWashingtonFamilyMedicalLeave;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class WashingtonFamilyMedicalLeave extends BaseWashingtonFamilyMedicalLeave
{
    use HasWageBase;

    const TAX_RATE = 0.004;
    const WAGE_BASE = 132900;
    const PERCENT = 0.6333;

    public function compute(Collection $tax_areas)
    {
        return round($this->payroll->withholdTax(min(($this->payroll->getEarnings() - $this->payroll->getTipAmount()) * self::PERCENT, ($this->getBaseEarnings() - $this->payroll->getTipAmount()) * self::PERCENT) * self::TAX_RATE), 2);
    }
}
