<?php

namespace Appleton\Taxes\Countries\US\Utah\UtahIncome\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Utah\UtahIncome\UtahIncome as BaseUtahIncome;
use Appleton\Taxes\Models\Countries\US\Utah\UtahIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class UtahIncome extends BaseUtahIncome
{
    private const TAX_RATE = 0.0495;
    private const ALLOWANCE_REDUCTION_AMOUNT = 0.013;
    private const SINGLE_AMOUNT = 7128;
    private const MARRIED_AMOUNT = 14256;
    private const SINGLE_BASE_ALLOWANCE = 360;
    private const MARRIED_BASE_ALLOWANCE = 720;

    public function compute(Collection $tax_areas)
    {
        $this->tax_total = $this->payroll->withholdTax((($this->getGrossAnnualTaxAmount() - $this->getAnnualWithholdingAllowance()) / $this->payroll->pay_periods) + $this->tax_information->additional_withholding);

        return round($this->tax_total, 2);
    }

    public function getGrossAnnualWages()
    {
        return (($this->getAdjustedEarnings() * $this->payroll->pay_periods));
    }

    public function getGrossAnnualTaxAmount()
    {
        return ($this->getGrossAnnualWages() * self::TAX_RATE);
    }

    public function getAnnualWithholdingAllowanceReduction()
    {
        $annual_withholding_allowance_reduction = 0;
        if ($this->tax_information->filing_status === 'S') {
            $annual_withholding_allowance_reduction = $this->getGrossAnnualWages() - self::SINGLE_AMOUNT;
        } else {
            $annual_withholding_allowance_reduction = $this->getGrossAnnualWages() - self::MARRIED_AMOUNT;
        }

        return $annual_withholding_allowance_reduction > 0 ? $annual_withholding_allowance_reduction * self::ALLOWANCE_REDUCTION_AMOUNT : 0;
    }

    public function getAnnualWithholdingAllowance()
    {
        $annual_withholding_allowance = 0;
        if ($this->tax_information->filing_status === 'S') {
            $annual_withholding_allowance = self::SINGLE_BASE_ALLOWANCE - $this->getAnnualWithholdingAllowanceReduction();
        } else {
            $annual_withholding_allowance = self::MARRIED_BASE_ALLOWANCE - $this->getAnnualWithholdingAllowanceReduction();
        }

        return $annual_withholding_allowance > 0 ? $annual_withholding_allowance : 0;
    }

    public function getTaxBrackets()
    {
        return 0;
    }
}
