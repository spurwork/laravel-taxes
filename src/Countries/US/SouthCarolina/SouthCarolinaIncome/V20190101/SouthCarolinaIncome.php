<?php
namespace Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaIncome\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaIncome\SouthCarolinaIncome as BaseSouthCarolinaIncome;
use Appleton\Taxes\Models\Countries\US\SouthCarolina\SouthCarolinaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class SouthCarolinaIncome extends BaseSouthCarolinaIncome
{
    const TAX_RATE = 0.05;
    const STANDARD_DEDUCTION = 3470;
    const DEDUCTION_ALLOWANCE = 2510;

    const TAX_WITHHOLDING_BRACKET = [
        [0, .011, 0],
        [2450, .03, 26.95],
        [4900, .04, 100.45],
        [7350, .05, 198.45],
        [9800, .06, 320.95],
        [12250, .07, 467.95],
    ];

    public function getTaxBrackets()
    {
        return self::TAX_WITHHOLDING_BRACKET;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getGrossWages() - $this->getStandardDeduction() - $this->getExemptionsAllowance(), $this->getTaxBrackets()) / $this->payroll->pay_periods);

        return round($this->tax_total, 2);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getExemptionsAllowance()
    {
        if ($this->tax_information->exemptions >= 1) {
            return $this->tax_information->exemptions * self::DEDUCTION_ALLOWANCE;
        }
    }

    public function getStandardDeduction()
    {
        if ($this->tax_information->exemptions >= 1) {
            return min(self::STANDARD_DEDUCTION, ($this->getGrossWages() * .1));
        }
    }
}
