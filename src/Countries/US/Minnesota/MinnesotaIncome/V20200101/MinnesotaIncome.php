<?php
namespace Appleton\Taxes\Countries\US\Minnesota\MinnesotaIncome\V20200101;

use Appleton\Taxes\Countries\US\Minnesota\MinnesotaIncome\MinnesotaIncome as BaseMinnesotaIncome;
use Illuminate\Database\Eloquent\Collection;

class MinnesotaIncome extends BaseMinnesotaIncome
{
    const WITHHOLDING_ALLOWANCE = 4250;

    const SINGLE_TAX_WITHHOLDING_BRACKET = [
        [0, 0, 0],
        [3700, .0535, 0],
        [30220, .068, 1418.82],
        [90810, .0785, 5538.94],
        [165420, .0985, 11395.83],
    ];

    const MARRIED_TAX_WITHHOLDING_BRACKET = [
        [0, 0, 0],
        [11650, .0535, 0],
        [50420, .068, 2074.2],
        [165670, .0785, 9911.2],
        [280660, .0985, 18937.92],
    ];

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === 'S') {
            return self::SINGLE_TAX_WITHHOLDING_BRACKET;
        }

        return self::MARRIED_TAX_WITHHOLDING_BRACKET;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getGrossWages() - $this->getWithholdingAllowances(), $this->getTaxBrackets()) / $this->payroll->pay_periods + $this->tax_information->additional_withholding);

        return round($this->tax_total, 2);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getWithholdingAllowances()
    {
        return $this->tax_information->allowances * self::WITHHOLDING_ALLOWANCE;
    }
}
