<?php

namespace Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsTax\V20190101;

use Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsTax\SacramentoBusinessOperationsTax as BaseSacramentoBusinessOperationsTax;
use Illuminate\Database\Eloquent\Collection;

class SacramentoBusinessOperationsTax extends BaseSacramentoBusinessOperationsTax
{
    public const SINGLE_LIABILITY = 30;
    public const TAX_RATE = 0.0004;
    public const TOTAL_WAGES = 10000;
    public const TOTAL_LIABILITIES = 5000;

    public function compute(Collection $tax_areas)
    {
        if ($this->payroll->getYtdLiabilities($tax_areas->first()->workGovernmentalUnitArea) >= self::TOTAL_LIABILITIES) {
            return 0;
        }
        // dump($this->payroll->getYtdEarnings($tax_areas->first()->workGovernmentalUnitArea).' ytd earnings');
        // dump($this->payroll->getYtdEarnings($tax_areas->first()->workGovernmentalUnitArea) >= self::TOTAL_WAGES);
        // dump($this->payroll->getYtdLiabilities($tax_areas->first()->workGovernmentalUnitArea) < self::TOTAL_LIABILITIES);
        // dump($this->payroll->getYtdLiabilities($tax_areas->first()->workGovernmentalUnitArea).' ytd liabilities');
        if ($this->payroll->getYtdEarnings($tax_areas->first()->workGovernmentalUnitArea) >= self::TOTAL_WAGES && $this->payroll->getYtdLiabilities($tax_areas->first()->workGovernmentalUnitArea) < self::TOTAL_LIABILITIES) {
            // dump($this->payroll->getEarnings());

            return round($this->payroll->withholdTax($this->payroll->getEarnings() * static::TAX_RATE), 2);
        }
        dump($this->payroll->getYtdLiabilities($tax_areas->first()->workGovernmentalUnitArea).' ytd liabilities');
    }
}
