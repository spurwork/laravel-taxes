<?php

namespace Appleton\Taxes\Countries\US\Utah\UtahIncome\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Utah\UtahIncome\UtahIncome as BaseUtahIncome;
use Appleton\Taxes\Models\Countries\US\Utah\UtahIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class UtahIncome extends BaseUtahIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0;

    const ANNUALLY = 4200;

    const MARRIED_FILING_JOINTLY_NEW_STEP_2_NOT_CHECKED = [
        [0, 0, 0],
        [24440, 0.1, 0],
        [43780, 0.12, 1940],
        [103380, 0.22, 9091],
        [192800, 0.24, 28767],
        [345800, 0.32, 65496],
        [432640, 0.35, 93252],
        [636740, 0.37, 164700],
    ];

    const MARRIED_FILING_JOINTLY_NEW_STEP_2_IS_CHECKED = [
        [0, 0, 0],
        [12220, 0.1, 0],
        [21890, 0.12, 967],
        [51690, 0.22, 4542],
        [96400, 0.24, 14381],
        [172900, 0.32, 32739],
        [216320, 0.35, 46634],
        [318400, 0.37, 82360],
    ];

    const SINGLE_NEW_STEP_2_NOT_CHECKED = [
        [0, 0, 0],
        [12220, 0.1, 0],
        [21890, 0.12, 967],
        [51690, 0.22, 4542],
        [96400, 0.24, 14381],
        [172900, 0.32, 32739],
        [216320, 0.35, 46634],
        [522500, 0.37, 153795],
    ];

    const SINGLE_NEW_STEP_2_IS_CHECKED = [
        [0, 0, 0],
        [6080, 0.1, 0],
        [10970, 0.12, 489],
        [25840, 0.22, 2273],
        [48200, 0.24, 7193],
        [86500, 0.32, 16378],
        [108160, 0.35, 23317],
        [261250, 0.37, 76898],
    ];

    const HEAD_OF_HOUSEHOLD_NEW_STEP_2_NOT_CHECKED = [
        [0, 0, 0],
        [18360, 0.1, 0],
        [32190, 0.12, 1383],
        [71190, 0.22, 6063],
        [102500, 0.24, 12962],
        [179040, 0.32, 31320],
        [222460, 0.35, 45214],
        [528630, 0.37, 152376],
    ];

    const HEAD_OF_HOUSEHOLD_NEW_STEP_2_IS_CHECKED = [
        [0, 0, 0],
        [9150, 0.1, 0],
        [16120, 0.12, 697],
        [35620, 0.22, 3037],
        [51270, 0.24, 6480],
        [89540, 0.32, 15666],
        [111230, 0.35, 22604],
        [264320, 0.37, 76185],
    ];

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $tax_amount = $this->getAdjustedWageAmount();
        $tax_amount = $this->getTentativeAmount($tax_amount);
        $tax_amount -= $this->tax_information->dependents_deduction_amount;
        $tax_amount = $tax_amount > 0 ? $tax_amount / $this->payroll->pay_periods : 0;
        $tax_amount += $this->tax_information->extra_withholding;

        $this->tax_total = $this->payroll->withholdTax($tax_amount);

        return round($this->tax_total, 2);
    }

    public function getAdjustedWageAmount()
    {
        $taxable_wages = $this->payroll->getEarnings() * $this->payroll->pay_periods;
        $taxable_wages += $this->tax_information->other_income;
        $taxable_wages -= $this->tax_information->deductions;
        $taxable_wages = $taxable_wages > 0 ? $taxable_wages : 0;

        return $taxable_wages;
    }

    public function getTentativeAmount($wages)
    {
        if ($this->tax_information->filing_status === static::FILING_HEAD_OF_HOUSEHOLD && $this->tax_information->step_2_checked) {
            return $this->getBracketAmount($wages, self::HEAD_OF_HOUSEHOLD_NEW_STEP_2_IS_CHECKED);
        } elseif ($this->tax_information->filing_status === static::FILING_HEAD_OF_HOUSEHOLD && !$this->tax_information->step_2_checked) {
            return $this->getBracketAmount($wages, self::HEAD_OF_HOUSEHOLD_NEW_STEP_2_NOT_CHECKED);
        } elseif ($this->tax_information->filing_status === static::FILING_JOINTLY && $this->tax_information->step_2_checked) {
            return $this->getBracketAmount($wages, self::MARRIED_FILING_JOINTLY_NEW_STEP_2_IS_CHECKED);
        } elseif ($this->tax_information->filing_status === static::FILING_JOINTLY && !$this->tax_information->step_2_checked) {
            return $this->getBracketAmount($wages, self::MARRIED_FILING_JOINTLY_NEW_STEP_2_NOT_CHECKED);
        } elseif ($this->tax_information->filing_status === static::FILING_SINGLE && $this->tax_information->step_2_checked) {
            return $this->getBracketAmount($wages, self::SINGLE_NEW_STEP_2_IS_CHECKED);
        } elseif ($this->tax_information->filing_status === static::FILING_SINGLE && !$this->tax_information->step_2_checked) {
            return $this->getBracketAmount($wages, self::SINGLE_NEW_STEP_2_NOT_CHECKED);
        }
    }

    public function getTaxBrackets()
    {
        return;
    }

    public function getBracketAmount($wages, $table)
    {
        $bracket = $this->getTaxBracket($wages, $table);
        $tax_amount = isset($bracket) ? ($wages - $bracket[0]) * $bracket[1] + $bracket[2] : 0;
        return $tax_amount > 0 ? $tax_amount : 0;
    }
}
