<?php

namespace Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\ConnecticutIncome as BaseConnecticutIncome;
use Appleton\Taxes\Models\Countries\US\Connecticut\ConnecticutIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class ConnecticutIncome extends BaseConnecticutIncome
{
    /*
    FILING_MARRIED_FILING_SEPARATELY
    FILING_MARRIED_FILING_JOINTLY_COMBINED_INCOME_LESS_THAN_OR_EQUAL_TO
    FILING_HEAD_OF_HOUSEHOLD
    FILING_MARRIED
    FILING_MARRIED_FILING_JOINTLY_ONE_SPOUSE_WORKING
    FILING_MARRIED_JOINTLY_COMBINED_INCOME_GREATER_THAN
    FILING_SINGLE
    */

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        if ($this->getPersonalExemption() === 0) {
            return $this->getPersonalExemption() - $this->tax_information->reduced_withholding + $this->tax_information->additional_withholding;
        }

        $annual_gross_tax_amount = $this->getTaxBracket($gross_earnings, self::ANNUAL_GROSS_TAX_AMOUNT);

        $phased_out_amount = $this->getTaxBracket($gross_earnings, self::PHASED_OUT);

        $additional_recapture_amount = $this->getTaxBracket($gross_earnings, self::ADDITONAL_RECAPTURE);

        $amount_of_tax_to_withhold = $annual_gross_tax_amount + $phased_out_amount + $additional_recapture_amount;

        $annual_tax_credit = $amount_of_tax_to_withhold * $this->getTaxBracket($gross_earnings, self::ANNUAL_GROSS_MULTIPLICATION_PERCENTAGE);

        $total = $amount_of_tax_to_withhold - $annual_tax_credit;

        $total = $total / $this->payroll->pay_periods;

        $total -= $this->tax_information->reduced_withholding;
        $total += $this->tax_information->additional_withholding;

        $this->tax_total = $this->payroll->withholdTax($total);
    }

    public function getPersonalExemption()
    {
        $gross_earnings = $this->getGrossAnnualWages();

        $standard_deduction = self::PERSONAL_EXEMPTION[$this->tax_information->filing_status];
        $deduction = $standard_deduction['amount'];

        if ($gross_earnings > $standard_deduction['base']) {
            $deduction -= $standard_deduction['modifier']['amount'] * ceil(($gross_earnings - $standard_deduction['base']) / $standard_deduction['modifier']['per']);
        }

        $deduction = $deduction < $standard_deduction['floor'] ? $standard_deduction['floor'] : $deduction;

        $gross_earnings = $gross_earnings - $deduction;

        return $gross_earnings < 0 ? $gross_earnings : 0;
    }

    public function getGrossAnnualWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getTaxBrackets(): array
    {
        dump('ho');
        return self::ANNUAL_GROSS_TAX_AMOUNT;
    }
    // public function getPersonalExemption()
    // {
    //     $gross_earnings = $this->getGrossEarnings();
    //     $personal_exemption = static::PERSONAL_EXEMPTION[$this->tax_information->filing_status];
    //     $deduction = $personal_exemption['amount'];

    //     if ($gross_earnings > $personal_exemption['base']) {
    //         $deduction -= $personal_exemption['modifier']['amount'] * ceil(($gross_earnings - $personal_exemption['base']) / $personal_exemption['modifier']['per']);
    //     }

    //     return $deduction < $personal_exemption['floor'] ? $personal_exemption['floor'] : $deduction;
    // }
}
