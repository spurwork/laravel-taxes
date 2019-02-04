<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave\V20190101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkFamilyMedicalLeave\NewYorkFamilyMedicalLeave as BaseNewYorkFamilyMedicalLeave;

class NewYorkFamilyMedicalLeave extends BaseNewYorkFamilyMedicalLeave
{
    const TAX_RATE = 0.00153;
    const WAGE_BASE = 1357.11;

    public function getBaseEarnings()
    {
        return max(min(static::WAGE_BASE - $this->payroll->wtd_earnings, $this->payroll->earnings), 0);
    }

    public function compute()
    {
        $this->tax_total = $this->payroll->withholdTax($this->getBaseEarnings() * static::TAX_RATE);
        return round($this->tax_total, 2);
    }
}
