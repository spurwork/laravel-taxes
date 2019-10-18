<?php
namespace Appleton\Taxes\Countries\US\Minnesota\MinnesotaIncome\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Minnesota\MinnesotaIncome\MinnesotaIncome as BaseMinnesotaIncome;
use Appleton\Taxes\Models\Countries\US\Minnesota\MinnesotaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class MinnesotaIncome extends BaseMinnesotaIncome
{
    const WITHHOLDING_ALLOWANCE = 4250;

    const SINGLE_TAX_WITHHOLDING_BRACKET = [
        [0, 0, 0],
        [2400, .0535, 0],
        [28920, .0705, 1418.82],
        [89510, .0785, 5690.42],
        [166290, .0985, 11717.65],
    ];

    const MARRIED_TAX_WITHHOLDING_BRACKET = [
        [0, 0, 0],
        [9050, .0535, 0],
        [47820, .0705, 2074.2],
        [163070, .0785, 10199.33],
        [282200, .0985, 19551.04],
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

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getGrossWages() - $this->getWithholdingAllowances(), $this->getTaxBrackets()) / $this->payroll->pay_periods);

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
