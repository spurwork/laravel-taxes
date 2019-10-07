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
        return round($this->payroll->withholdTax(min($this->payroll->getEarnings() * self::PERCENT, $this->getBaseEarnings() * self::PERCENT) * self::TAX_RATE), 2);
    }

    // public function compute(Collection $tax_areas)
    // {
    //     return round($this->getAdjustedEarnings() * self::TAX_RATE, 2);
    // }

    // public function getAdjustedEarnings()
    // {
    //     return min($this->payroll->getEarnings(), $this->getBaseEarnings());
    // }
}
