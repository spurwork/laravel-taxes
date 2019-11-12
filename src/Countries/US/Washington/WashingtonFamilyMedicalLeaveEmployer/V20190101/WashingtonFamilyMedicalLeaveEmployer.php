<?php


namespace Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeaveEmployer\V20190101;

use Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeaveEmployer\WashingtonFamilyMedicalLeaveEmployer
    as BaseWashingtonFamilyMedicalLeaveEmployer;
use Illuminate\Database\Eloquent\Collection;

class WashingtonFamilyMedicalLeaveEmployer extends BaseWashingtonFamilyMedicalLeaveEmployer
{
    const WAGE_BASE = 132900;
    const TAX_RATE = 0.004;
    const PERCENT = 0.3667;

    public function compute(Collection $tax_areas)
    {
        $tip_amount = $this->payroll->getTipAmount($tax_areas->first()->workGovernmentalUnitArea);

        return round($this->payroll->withholdTax(min(($this->payroll->getEarnings() - $tip_amount) * self::TAX_RATE, ($this->getBaseEarnings() - $tip_amount) * self::TAX_RATE) * self::PERCENT), 2);
    }
}
