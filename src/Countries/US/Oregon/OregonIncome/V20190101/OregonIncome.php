<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Oregon\OregonIncome\OregonIncome as BaseOregonIncome;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class OregonIncome extends BaseOregonIncome
{
    const SINGLE_LESS_THAN_THREE_EXEMPTIONS_DEDUCTION = 2270;
    const SINGLE_THREE_OR_MORE_EXEMPTIONS_DEDUCTION = 4545;
    const MARRIED_DEDUCTION = 4545;

    const ANNUAL_TAX_CREDIT = 206;

    const SINGLE_MAXIMUM_FEDERAL_DEDUCTION = [
        [0, 6800],
        [124999.99, 5450],
        [129999.99, 4100],
        [134999.99, 2700],
        [139999.99, 1350],
        [144999.99, 0],
    ];

    const MARRIED_MAXIMUM_FEDERAL_DEDUCTION = [
        [0, 6800],
        [249999.99, 5450],
        [259999.99, 4100],
        [269999.99, 2700],
        [279999.99, 1350],
        [289999.99, 0],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_LESS_THEN_3_EXEMPTIONS_LESS_THAN_50000 = [
        [0, 0.05, 206],
        [3550, 0.07, 383.5],
        [8900, 0.09, 758],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_LESS_THAN_50000 = [
        [0, 0.05, 206],
        [7100, 0.07, 561],
        [17800, 0.09, 1310],
    ];

    const TAX_WITHHOLDING_TABLE_MARRIED_LESS_THAN_50000 = [
        [0, 0.05, 206],
        [7100, 0.07, 561],
        [17800, 0.09, 1310],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_LESS_THEN_3_EXEMPTIONS_MORE_THAN_50000 = [
        [0, 0, 0],
        [8900, 0.0, 552],
        [125000, 0.099, 11001],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_MORE_THAN_50000 = [
        [0, 0, 0],
        [17800, 0.09, 1104],
        [250000, 0.099, 22002],
    ];

    const TAX_WITHHOLDING_TABLE_MARRIED_MORE_THAN_50000 = [
        [0, 0, 0],
        [17800, 0.09, 1104],
        [250000, 0.099, 22002],
    ];

    public $gross_annual_wages;

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption() || $this->tax_information->filing_status === 'E') {
            return 0.0;
        }

        $this->gross_annual_wages = $this->getGrossAnnualWages();
        $this->gross_annual_wages -= $this->getAnnualizedTaxableWages();

        if ($this->tax_information->filing_status === 'M') {
            $this->gross_annual_wages -= self::MARRIED_DEDUCTION;
        } elseif ($this->tax_information->filing_status === 'S' && $this->tax_information->exemptions >= 3) {
            $this->gross_annual_wages -= self::SINGLE_THREE_OR_MORE_EXEMPTIONS_DEDUCTION;
        } else {
            $this->gross_annual_wages -= self::SINGLE_LESS_THAN_THREE_EXEMPTIONS_DEDUCTION;
        }

        if ($this->getGrossAnnualWages() < 50000) {
            if ($this->tax_information->filing_status === 'M') {
                $this->gross_annual_wages = $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_MARRIED_LESS_THAN_50000);
            } elseif ($this->tax_information->filing_status === 'S' && $this->tax_information->exemptions >= 3) {
                $this->gross_annual_wages = $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_LESS_THAN_50000);
            } else {
                $this->gross_annual_wages = $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_SINGLE_LESS_THEN_3_EXEMPTIONS_LESS_THAN_50000);
            }
        } else {
            if ($this->tax_information->filing_status === 'M') {
                $this->gross_annual_wages = $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_MARRIED_MORE_THAN_50000);
            } elseif ($this->tax_information->filing_status === 'S' && $this->tax_information->exemptions >= 3) {
                $this->gross_annual_wages = $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_MORE_THAN_50000);
            } else {
                $this->gross_annual_wages = $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_SINGLE_LESS_THEN_3_EXEMPTIONS_MORE_THAN_50000);
            }
        }

        if ($this->tax_information->filing_status === 'S' && $this->getGrossAnnualWages() > 100000 && $this->tax_information->exemptions > 1) {
            $this->gross_annual_wages -= ($this->tax_information->exemptions - 1) * self::ANNUAL_TAX_CREDIT;
        } elseif ($this->tax_information->filing_status === 'M' && $this->getGrossAnnualWages() > 200000 && $this->tax_information->exemptions === 1) {
            $this->gross_annual_wages -= ($this->tax_information->exemptions - 1) * self::ANNUAL_TAX_CREDIT;
        } elseif ($this->tax_information->filing_status === 'M' && $this->getGrossAnnualWages() > 200000 && $this->tax_information->exemptions >= 2) {
            $this->gross_annual_wages -= ($this->tax_information->exemptions - 2) * self::ANNUAL_TAX_CREDIT;
        } else {
            $this->gross_annual_wages -= $this->tax_information->exemptions * self::ANNUAL_TAX_CREDIT;
        }

        $this->gross_annual_wages > 0 ? $this->gross_annual_wages /= $this->payroll->pay_periods : 0;
        $this->gross_annual_wages += $this->tax_information->additional_withholding;

        $this->tax_total = $this->gross_annual_wages;
        return round($this->payroll->withholdTax($this->tax_total), 2);
    }

    public function getGrossAnnualWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getTaxBrackets(): array
    {
        if ($this->tax_information->filing_status === 'S') {
            return self::SINGLE_MAXIMUM_FEDERAL_DEDUCTION;
        }

        return self::MARRIED_MAXIMUM_FEDERAL_DEDUCTION;
    }

    public function getBracketAmount($wages, $table)
    {
        $bracket = $this->getTaxBracket($wages, $table);

        return $bracket[1];
    }

    public function getAnnualizedTaxableWages()
    {
        return $annualized_taxable_wages = min($this->getBracketAmount($this->gross_annual_wages, $this->getTaxBrackets()), ($this->federal_income_tax * $this->payroll->pay_periods));
    }
}
