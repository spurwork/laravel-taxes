<?php

namespace Appleton\Taxes\Countries\US\Hawaii\HawaiiIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Hawaii\HawaiiIncome\HawaiiIncome as BaseHawaiiIncome;
use Appleton\Taxes\Models\Countries\US\Hawaii\HawaiiIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class HawaiiIncome extends BaseHawaiiIncome
{
    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getExemptionAllowance(), $this->getTaxBrackets()) / $this->payroll->pay_periods + $this->tax_information->additional_withholding);

        return round($this->tax_total, 2);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getExemptionAllowance()
    {
        return $this->getGrossWages() - ($this->tax_information->exemptions * self::EXEMPTION_AMOUNT);
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === 'M') {
            return self::MARRIED_WITHHOLDING_TABLE;
        } elseif ($this->tax_information->filing_status === 'H') {
            return self::SINGLE_WITHHOLDING_TABLE;
        } else {
            return self::SINGLE_WITHHOLDING_TABLE;
        }
    }
}
