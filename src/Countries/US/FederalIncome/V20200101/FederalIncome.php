<?php

namespace Appleton\Taxes\Countries\US\FederalIncome\V20200101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class FederalIncome extends BaseFederalIncome
{
    const WEEKLY = 81;

    const SINGLE_BRACKETS_OLD = [
        [0, 0.0, 0],
        [3800, 0.1, 0],
        [13500, 0.12, 970],
        [43275, 0.22, 4543],
        [88000, 0.24, 14382.5],
        [164525, 0.32, 32748.5],
        [207900, 0.35, 46628.5],
        [514100, 0.37, 153798.5],
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
        // new
        $this->tax_total = $this->payroll->withholdTax($this->getAmountToWithhold());

        // old
        $this->tax_total = $this->payroll->withholdTax($this->getTentativeAmount() + $this->tax_information->additional_withholding);

        return round($this->tax_total, 2);
    }

    public function getTaxableWages()
    {
        // new
        // adding $this->tax_information->other_income
        // adding $this->tax_information->deductions
        $taxable_wages = ($this->payroll->getEarnings() + ($this->tax_information->other_income / $this->payroll->pay_periods) - ($this->tax_information->deductions / $this->payroll->pay_periods));

        // old
        $taxable_wages = $this->payroll->getEarnings() - ($this->tax_information->exemptions * self::WEEKLY);

        return $taxable_wages > 0 ? $taxable_wages : 0;
    }

    public function getAmountToWithhold()
    {
        // adding $this->tax_information->extra_withholding
        return $this->tax_information->extra_withholding + $this->getTaxCredits();
    }

    public function getTaxCredits()
    {
        $tax_credit_amount = $this->getTentativeAmount() - ($this->tax_information->dependents_total / $this->payroll->pay_periods);

        return $tax_credit_amount > 0 ? $tax_credit_amount : 0;
    }

    public function getTentativeAmount()
    {
        // new
        if ($this->getTaxBrackets() === static::FILING_MARRIED) {
            return $this->getTaxBracket($this->getTaxableWages(), self::MARRIED_BRACKETS_OLD);
        } elseif ($this->getTaxBrackets() === static::FILING_SINGLE) {
            return $this->getTaxBracket($this->getTaxableWages(), self::SINGLE_BRACKETS_OLD);
        }

        // old
        // using tax_information to see if they checked box
        // adding $this->tax_information->checked
        // adding $this->tax_information->additional_withholding
        if ($this->getTaxBrackets() === static::FILING_HEAD_OF_HOUSEHOLD && $this->tax_information->checked) {
            return $this->getTaxBracket($this->getTaxableWages(), self::HEAD_OF_HOUSEHOLD_NEW_STEP_2_IS_CHECKED);
        } elseif ($this->getTaxBrackets() === static::FILING_HEAD_OF_HOUSEHOLD && !$this->tax_information->checked) {
            return $this->getTaxBracket($this->getTaxableWages(), self::HEAD_OF_HOUSEHOLD_NEW_STEP_2_NOT_CHECKED);
        } elseif ($this->getTaxBrackets() === static::FILING_JOINTLY && $this->tax_information->checked) {
            return $this->getTaxBracket($this->getTaxableWages(), self::MARRIED_FILING_JOINTLY_NEW_STEP_2_IS_CHECKED);
        } elseif ($this->getTaxBrackets() === static::FILING_JOINTLY && !$this->tax_information->checked) {
            return $this->getTaxBracket($this->getTaxableWages(), self::MARRIED_FILING_JOINTLY_NEW_STEP_2_NOT_CHECKED);
        } elseif ($this->getTaxBrackets() === static::FILING_SINGLE && $this->tax_information->checked) {
            return $this->getTaxBracket($this->getTaxableWages(), self::SINGLE_NEW_STEP_2_IS_CHECKED);
        } elseif ($this->getTaxBrackets() === static::FILING_SINGLE && !$this->tax_information->checked) {
            return $this->getTaxBracket($this->getTaxableWages(), self::SINGLE_NEW_STEP_2_NOT_CHECKED);
        }
    }

    public function getTaxBrackets()
    {
        // new
        return ($this->tax_information->filing_status === static::FILING_MARRIED) ? static::MARRIED_BRACKETS : static::SINGLE_BRACKETS;

        // old
        if ($this->tax_information->filing_status === static::FILING_JOINTLY) {
            return static::FILING_JOINTLY;
        } elseif ($this->tax_information->filing_status === static::FILING_HEAD_OF_HOUSEHOLD) {
            return static::FILING_HEAD_OF_HOUSEHOLD;
        } else {
            return static::FILING_SINGLE;
        }
    }
}
