<?php

namespace Appleton\Taxes\Countries\US\Missouri\MissouriIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Missouri\MissouriIncome\MissouriIncome as BaseMissouriIncome;
use Appleton\Taxes\Models\Countries\US\Missouri\MissouriIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class MissouriIncome extends BaseMissouriIncome
{
    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getAnnualTaxAmount(), $this->getTaxBrackets()) / $this->payroll->pay_periods + $this->tax_information->additional_withholding);

        return round($this->tax_total, 2);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getAnnualTaxAmount()
    {
        $gross_wages = $this->getGrossWages();
        return $gross_wages < self::EXEMPTION_GROSS_WAGES ? $gross_wages - ($this->tax_information->exemptions * self::EXEMPTION_AMOUNT) : $gross_wages;
    }

    public function getTaxBrackets()
    {
        return self::TAX_WITHHOLDING_AMOUNT;
    }

    public function getStandardDeduction()
    {
        if ($this->tax_information->filing_status === 'S') {
			return self::
        }
    }
}
