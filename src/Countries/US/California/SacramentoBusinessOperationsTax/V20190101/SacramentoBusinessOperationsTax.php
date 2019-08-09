<?php

namespace Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsTax\V20190101;

use Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsTax\SacramentoBusinessOperationsTax as BaseSacramentoBusinessOperationsTax;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class SacramentoBusinessOperationsTax extends BaseSacramentoBusinessOperationsTax
{
    const SINGLE_LIABILITY = 30;
    const TAX_RATE = 0.0004;
    const TOTAL_WAGES = 10000;
    const TOTAL_LIABILITIES = 5000;

    public function compute(Collection $tax_areas)
    {
        if ($this->payroll->getYtdEarnings($tax_areas->first()->workGovernmentalUnitArea) === 0) {
            return $this->payroll->withholdTax(self::SINGLE_LIABILITY);
        }

        if ($this->payroll->getYtdLiabilities($tax_areas->first()->workGovernmentalUnitArea) >= self::TOTAL_LIABILITIES) {
            return 0;
        }

        if ($this->payroll->getYtdEarnings($tax_areas->first()->workGovernmentalUnitArea) > 0 && $this->payroll->getYtdEarnings($tax_areas->first()->workGovernmentalUnitArea) < self::TOTAL_WAGES) {
            $tax_total = $this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE);
            return round($tax_total, 2);
        }
    }
}
