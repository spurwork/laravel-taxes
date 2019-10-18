<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonIncome\V20190101;

use Appleton\Taxes\Countries\US\Oregon\OregonIncome\OregonIncome as BaseOregonIncome;
use Illuminate\Database\Eloquent\Collection;

class OregonIncome extends BaseOregonIncome
{
    public $gross_annual_wages;

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption() || $this->tax_information->filing_status === 'E') {
            return 0.0;
        }

        $this->gross_annual_wages = $this->getGrossAnnualWages();
        $this->gross_annual_wages -= $this->getAnnualizedTaxableWages();
        $this->gross_annual_wages -= $this->getStandardDeduction();
        $this->gross_annual_wages = $this->getAnnualTaxAmount();
        $this->gross_annual_wages -= $this->getPersonalAllowance();

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

    public function getStandardDeduction()
    {
        if ($this->tax_information->filing_status === 'M') {
            return self::MARRIED_DEDUCTION;
        } elseif ($this->tax_information->filing_status === 'S' && $this->tax_information->exemptions >= 3) {
            return self::SINGLE_THREE_OR_MORE_EXEMPTIONS_DEDUCTION;
        } else {
            return self::SINGLE_LESS_THAN_THREE_EXEMPTIONS_DEDUCTION;
        }
    }

    public function getAnnualTaxAmount()
    {
        if ($this->getGrossAnnualWages() < 50000) {
            if ($this->tax_information->filing_status === 'M') {
                return $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_MARRIED_LESS_THAN_50000);
            } elseif ($this->tax_information->filing_status === 'S' && $this->tax_information->exemptions >= 3) {
                return $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_LESS_THAN_50000);
            } else {
                return $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_SINGLE_LESS_THEN_3_EXEMPTIONS_LESS_THAN_50000);
            }
        } else {
            if ($this->tax_information->filing_status === 'M') {
                return $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_MARRIED_MORE_THAN_50000);
            } elseif ($this->tax_information->filing_status === 'S' && $this->tax_information->exemptions >= 3) {
                return $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_MORE_THAN_50000);
            } else {
                return $this->getTaxAmountFromTaxBrackets($this->gross_annual_wages, self::TAX_WITHHOLDING_TABLE_SINGLE_LESS_THEN_3_EXEMPTIONS_MORE_THAN_50000);
            }
        }
    }

    public function getPersonalAllowance()
    {
        if ($this->tax_information->filing_status === 'S' && $this->getGrossAnnualWages() > 100000 && $this->tax_information->exemptions > 1) {
            $this->gross_annual_wages -= ($this->tax_information->exemptions - 1) * self::ANNUAL_TAX_CREDIT;
        } elseif ($this->tax_information->filing_status === 'M' && $this->getGrossAnnualWages() > 200000 && $this->tax_information->exemptions === 1) {
            $this->gross_annual_wages -= ($this->tax_information->exemptions - 1) * self::ANNUAL_TAX_CREDIT;
        } elseif ($this->tax_information->filing_status === 'M' && $this->getGrossAnnualWages() > 200000 && $this->tax_information->exemptions >= 2) {
            $this->gross_annual_wages -= ($this->tax_information->exemptions - 2) * self::ANNUAL_TAX_CREDIT;
        } else {
            $this->gross_annual_wages -= $this->tax_information->exemptions * self::ANNUAL_TAX_CREDIT;
        }
    }
}
