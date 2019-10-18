<?php

namespace Appleton\Taxes\Countries\US\Delaware\DelawareIncome\V20190101;

use Appleton\Taxes\Countries\US\Delaware\DelawareIncome\DelawareIncome as BaseDelawareIncome;
use Illuminate\Database\Eloquent\Collection;

class DelawareIncome extends BaseDelawareIncome
{
    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax(($this->getTaxAmountFromTaxBrackets($this->getStandardDeduction(), $this->getTaxBrackets()) - $this->getExemptionAllowance()) / $this->payroll->pay_periods) + $this->getAdditionalWithholding();

        return round($this->tax_total, 2);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getStandardDeduction()
    {
        if ($this->tax_information->filing_status === static::FILING_MARRIED_FILING_JOINTLY) {
            return $this->getGrossWages() - self::MARRIED_FILING_JOINTLY_STANDARD_DEDUCTION;
        } elseif ($this->tax_information->filing_status === static::FILING_MARRIED_FILING_SEPARATELY) {
            return $this->getGrossWages() - self::MARRIED_FILING_SEPARATELY_STANDARD_DEDUCTION;
        } else {
            return $this->getGrossWages() - self::SINGLE_STANDARD_DEDUCTION;
        }
    }

    public function getExemptionAllowance()
    {
        return $this->tax_information->exemptions * self::EXEMPTION_ALLOWANCE;
    }

    public function getTaxBrackets()
    {
        return self::WITHHOLDING_TABLE;
    }
}
