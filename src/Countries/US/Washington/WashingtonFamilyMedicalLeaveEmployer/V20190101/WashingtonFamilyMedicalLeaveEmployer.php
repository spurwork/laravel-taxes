<?php


namespace Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeaveEmployer\V20190101;

use Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeaveEmployer\WashingtonFamilyMedicalLeaveEmployer as BaseWashingtonFamilyMedicalLeaveEmployer;
use Illuminate\Database\Eloquent\Collection;

class WashingtonFamilyMedicalLeaveEmployer extends BaseWashingtonFamilyMedicalLeaveEmployer
{
    const WAGE_BASE = 132900;
    const TAX_RATE = 0.004;
    const PERCENT = 0.3667;

    public function compute(Collection $tax_areas)
    {
        $tip_amount = $this->payroll->getTipAmount($tax_areas->first()->workGovernmentalUnitArea);
        $earnings = $this->payroll->getEarnings($tax_areas->first()->workGovernmentalUnitArea) - $tip_amount;

        $ytd_taxable_earnings = $this->payroll->getYtdTaxableWages(BaseWashingtonFamilyMedicalLeaveEmployer::class);
        $taxable_earnings = static::WAGE_BASE - $ytd_taxable_earnings;
        $tax_amount = min($earnings, $taxable_earnings) * self::TAX_RATE * self::PERCENT;

        return round($tax_amount, 2);
    }
}
