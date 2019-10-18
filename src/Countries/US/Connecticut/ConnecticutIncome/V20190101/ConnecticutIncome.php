<?php

namespace Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\V20190101;

use Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\ConnecticutIncome as BaseConnecticutIncome;
use Illuminate\Database\Eloquent\Collection;

class ConnecticutIncome extends BaseConnecticutIncome
{
    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption() || $this->tax_information->filing_status === 'E') {
            return 0;
        }

        $employee_taxable_income = $this->getPersonalExemption();

        if ($employee_taxable_income === 0) {
            return $employee_taxable_income - $this->tax_information->reduced_withholding + $this->tax_information->additional_withholding;
        }

        $annual_gross_tax_amount = $this->getTaxAmountFromTaxBrackets($employee_taxable_income, self::ANNUAL_GROSS_TAX_AMOUNT[$this->tax_information->filing_status]);
        $phased_out_amount = $this->getBracketAmount($this->getGrossAnnualWages(), self::PHASED_OUT[$this->tax_information->filing_status]);

        $annual_gross_tax_amount += $phased_out_amount;

        $additional_recapture_amount = $this->getBracketAmount($this->getGrossAnnualWages(), self::ADDITIONAL_RECAPTURE[$this->tax_information->filing_status]);
        $annual_gross_tax_amount += $additional_recapture_amount;

        if ($this->tax_information->filing_status !== 'D') {
            $tax_credit_percentage = $this->getBracketAmount($this->getGrossAnnualWages(), self::ANNUAL_GROSS_MULTIPLICATION_PERCENTAGE[$this->tax_information->filing_status]);
            $annual_tax_credit = $annual_gross_tax_amount * $tax_credit_percentage;
            $annual_gross_tax_amount -= $annual_tax_credit;
        }

        $annual_gross_tax_amount /= $this->payroll->pay_periods;
        $annual_gross_tax_amount -= $this->tax_information->reduced_withholding;
        $annual_gross_tax_amount += $this->tax_information->additional_withholding;

        return round($this->payroll->withholdTax($annual_gross_tax_amount), 2);
    }

    public function getPersonalExemption()
    {
        $gross_earnings = $this->getGrossAnnualWages();

        if ($this->tax_information->filing_status !== 'D') {
            $standard_deduction = self::PERSONAL_EXEMPTION[$this->tax_information->filing_status];
            $deduction = $standard_deduction['amount'];

            if ($gross_earnings > $standard_deduction['base']) {
                $deduction -= $standard_deduction['modifier']['amount'] * ceil(($gross_earnings - $standard_deduction['base']) / $standard_deduction['modifier']['per']);
            }

            $deduction = $deduction < $standard_deduction['floor'] ? $standard_deduction['floor'] : $deduction;
            $gross_earnings = $gross_earnings - $deduction;
        }

        return $gross_earnings > 0 ? $gross_earnings : 0;
    }

    public function getGrossAnnualWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getTaxBrackets(): array
    {
        return self::ANNUAL_GROSS_TAX_AMOUNT[$this->tax_information->filing_status];
    }

    public function getBracketAmount($wages, $table)
    {
        $bracket = $this->getTaxBracket($wages, $table);

        return $bracket[1];
    }
}
