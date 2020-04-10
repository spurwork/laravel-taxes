<?php

namespace Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeave\V20190101;

use Appleton\Taxes\Countries\US\Washington\WashingtonFamilyMedicalLeave\WashingtonFamilyMedicalLeave as BaseWashingtonFamilyMedicalLeave;
use Illuminate\Database\Eloquent\Collection;

class WashingtonFamilyMedicalLeave extends BaseWashingtonFamilyMedicalLeave
{
    const TAX_RATE = 0.004;
    const WAGE_BASE = 132900;
    const PERCENT = 0.6333;

    public function compute(Collection $tax_areas)
    {
        $tip_amount = $this->payroll->getTipAmount($tax_areas->first()->workGovernmentalUnitArea);
        $earnings = $this->payroll->getEarnings($tax_areas->first()->workGovernmentalUnitArea) - $tip_amount;

        $ytd_taxable_earnings = $this->payroll->getYtdTaxableWages(BaseWashingtonFamilyMedicalLeave::class);
        $taxable_earnings = static::WAGE_BASE - $ytd_taxable_earnings;
        $tax_amount = min($earnings, $taxable_earnings) * self::TAX_RATE * self::PERCENT;

        return round($this->payroll->withholdTax($tax_amount), 2);
    }
}
