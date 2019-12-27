<?php

namespace Appleton\Taxes\Countries\US\FederalIncome\V20190101;

// use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
// use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
// use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

// class FederalIncome extends BaseFederalIncome
// {
//     const SUPPLEMENTAL_TAX_RATE = 0.22;

//     const EXEMPTION_AMOUNT = 4200;
//     const NON_RESIDENT_ALIEN_AMOUNT = 7850;

//     const SINGLE_BRACKETS = [
//         [0, 0.0, 0],
//         [3800, 0.1, 0],
//         [13500, 0.12, 970],
//         [43275, 0.22, 4543],
//         [88000, 0.24, 14382.5],
//         [164525, 0.32, 32748.5],
//         [207900, 0.35, 46628.5],
//         [514100, 0.37, 153798.5],
//     ];

//     const MARRIED_BRACKETS = [
//         [0, 0.0, 0],
//         [11800, 0.1, 0],
//         [31200, 0.12, 1940],
//         [90750, 0.22, 9086],
//         [180200, 0.24, 28765],
//         [333250, 0.32, 65497],
//         [420000, 0.35, 93257],
//         [624150, 0.37, 164709.5],
//     ];

//     public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
//     {
//         parent::__construct($tax_information, $payroll);
//         $this->tax_information = $tax_information;
//     }

//     public function getAdjustedEarnings()
//     {
//         return (($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings()) * $this->payroll->pay_periods) - ($this->tax_information->exemptions * static::EXEMPTION_AMOUNT) + ($this->tax_information->non_resident_alien ? static::NON_RESIDENT_ALIEN_AMOUNT : 0);
//     }

//     public function getTaxBrackets()
//     {
//         return ($this->tax_information->filing_status === static::FILING_MARRIED) ? static::MARRIED_BRACKETS : static::SINGLE_BRACKETS;
//     }
// }


use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class FederalIncome extends BaseFederalIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0;

    const ANNUALLY = 4200;
    const FORM_VERSION_2019 = '2019';
    const FORM_VERSION_2020 = '2020';

    const SINGLE_BRACKETS_OLD = [
        [0, 0.0, 0],
        [3800, 0.1, 0],
        [13500, 0.12, 970],
        [43275, 0.22, 4543],
        [88000, 0.24, 14382],
        [164525, 0.32, 32748],
        [207900, 0.35, 46628],
        [514100, 0.37, 153798],
    ];

    const MARRIED_BRACKETS_OLD = [
        [0, 0.0, 0],
        [11800, 0.1, 0],
        [31200, 0.12, 1940],
        [90750, 0.22, 9086],
        [180200, 0.24, 28765],
        [333250, 0.32, 65497],
        [420000, 0.35, 93257],
        [624150, 0.37, 164710],
    ];

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

    public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->form_version === self::FORM_VERSION_2020) {
            $taxable_wages = $this->getAdjustedWageAmount();
            $taxable_wages = $this->getTentativeAmount($taxable_wages);
            $taxable_wages -= $this->tax_information->dependents_deduction_amount;
            $taxable_wages = $taxable_wages > 0 ? $taxable_wages : 0;
            $taxable_wages = $taxable_wages > 0 ? $taxable_wages / $this->payroll->pay_periods : 0;
            $taxable_wages += $this->tax_information->extra_withholding / 100;

            $this->tax_total = $this->payroll->withholdTax($taxable_wages);
        } elseif ($this->tax_information->form_version === self::FORM_VERSION_2019) {
            $taxable_wages = ($this->payroll->getEarnings() * $this->payroll->pay_periods) - ($this->tax_information->exemptions * self::ANNUALLY);

            $taxable_wages = $this->getTentativeAmount($taxable_wages);
            $taxable_wages += $this->getAdditionalWithholding();

            $this->tax_total = $this->payroll->withholdTax($taxable_wages / $this->payroll->pay_periods);
        }

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
        if ($this->tax_information->form_version === self::FORM_VERSION_2020) {
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
        } elseif ($this->tax_information->form_version === self::FORM_VERSION_2019) {
            if ($this->tax_information->filing_status === static::FILING_MARRIED) {
                return $this->getBracketAmount($wages, self::MARRIED_BRACKETS_OLD);
            } elseif ($this->tax_information->filing_status === static::FILING_SINGLE) {
                return $this->getBracketAmount($wages, self::SINGLE_BRACKETS_OLD);
            }
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
