<?php

namespace Appleton\Taxes\Countries\US\Ohio\OhioIncome\V20190101;

use Appleton\Taxes\Countries\US\Ohio\OhioIncome\OhioIncome as BaseOhioIncome;
use Illuminate\Database\Eloquent\Collection;

class OhioIncome extends BaseOhioIncome
{
    const TAX_RATE = 0.05;

    const TAX_WITHHOLDING_BRACKET = [
        [0, .005, 0],
        [5000, .01, 25],
        [10000, .02, 75],
        [15000, .025, 175],
        [20000, .03, 300],
        [40000, .035, 900],
        [80000, .04, 2300],
        [100000, .05, 3100],
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

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets(($this->getAdjustedEarnings() * $this->payroll->pay_periods) - $this->getDependentAllowance(), $this->getTaxBrackets()) / $this->payroll->pay_periods) * 1.075;

        return round(intval($this->tax_total * 100) / 100, 2);
    }

    public function getDependentAllowance()
    {
        return $this->tax_information->dependents * 650;
    }
}
