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
        $tip_amount = $this->payroll->getTipAmount($tax_areas->first()->workGovernmentalUnitArea);

        return round($this->payroll->withholdTax(min(($this->payroll->getEarnings($tax_areas->first()->workGovernmentalUnitArea) - $tip_amount) * self::TAX_RATE, ($this->getBaseEarnings() - $tip_amount) * self::TAX_RATE) * self::PERCENT), 2);
    }
}
