<?php
namespace Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaIncome\V20190101;

use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaIncome\SouthCarolinaIncome as BaseSouthCarolinaIncome;
use Illuminate\Database\Eloquent\Collection;

class SouthCarolinaIncome extends BaseSouthCarolinaIncome
{
    const TAX_RATE = 0.05;
    const STANDARD_DEDUCTION = 3820;
    const DEDUCTION_ALLOWANCE = 2590;

    const TAX_WITHHOLDING_BRACKET = [
        [0, .008, 0],
        [2620, .03, 20.96],
        [5240, .04, 99.56],
        [7860, .05, 204.36],
        [10490, .06, 335.86],
        [13110, .07, 493.06],
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

        $this->tax_total = $this->payroll->withholdTax(($this->getTaxAmountFromTaxBrackets($this->getGrossWages() - $this->getStandardDeduction() - $this->getExemptionsAllowance(), $this->getTaxBrackets()) / $this->payroll->pay_periods) + $this->tax_information->additional_withholding);

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
