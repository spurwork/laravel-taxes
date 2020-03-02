<?php

namespace Appleton\Taxes\Countries\US\Missouri\MissouriIncome\V20190101;

use Appleton\Taxes\Countries\US\Missouri\MissouriIncome\MissouriIncome as BaseMissouriIncome;
use Illuminate\Database\Eloquent\Collection;

class MissouriIncome extends BaseMissouriIncome
{
    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        if ($this->tax_information->has_reduced_withholding) {
            $this->tax_total = $this->payroll->withholdTax($this->tax_information->reduced_withholding);
        } else {
            $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getStandardDeduction(), $this->getTaxBrackets()) / $this->payroll->pay_periods + $this->tax_information->additional_withholding);
        }

        return (int)round(intval($this->tax_total * 100) / 100, 0);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getStandardDeduction()
    {
        if ($this->tax_information->filing_status === 'M') {
            return $this->getGrossWages() - self::MARRIED_ONE_SPOUSE_WORKING_STANDARD_DEDUCTION;
        } elseif ($this->tax_information->filing_status === 'H') {
            return $this->getGrossWages() - self::HEAD_OF_HOUSEHOLD_STANDARD_DEDUCTION;
        } elseif ($this->tax_information->filing_status === 'N') {
            return $this->getGrossWages() - self::MARRIED_BOTH_SPOUSE_WORKING_STANDARD_DEDUCTION;
        } elseif ($this->tax_information->filing_status === 'N') {
            return $this->getGrossWages() - self::MARRIED_FILING_SEPARATELY_STANDARD_DEDUCTION;
        } else {
            return $this->getGrossWages() - self::SINGLE_STANDARD_DEDUCTION;
        }
    }

    public function getTaxBrackets()
    {
        return self::TAX_WITHHOLDING_TABLE;
    }
}
