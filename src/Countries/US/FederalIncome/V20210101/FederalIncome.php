<?php

namespace Appleton\Taxes\Countries\US\FederalIncome\V20210101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class FederalIncome extends BaseFederalIncome
{
    private const FORM_VERSION_2020 = '2020';

    private const MARRIED_WITHOUT_STEP_2 = [
        [0, 0.0, 0],
        [12200, 0.1, 0],
        [32100, 0.12, 1990],
        [93250, 0.22, 9328],
        [184950, 0.24, 29502],
        [342050, 0.32, 67206],
        [431050, 0.35, 95686],
        [640500, 0.37, 168993.5],
    ];

    private const SINGLE_WITHOUT_STEP_2 = [
        [0, 0.0, 0],
        [3950, 0.1, 0],
        [13900, 0.12, 995],
        [44475, 0.22, 4664],
        [90325, 0.24, 14751],
        [168875, 0.32, 33603],
        [213375, 0.35, 47843],
        [527550, 0.37, 157804.25],
    ];

    private const HEAD_OF_HOUSEHOLD_WITHOUT_STEP_2 = [
        [0, 0.0, 0],
        [10200, 0.1, 0],
        [24400, 0.12, 1420],
        [64400, 0.22, 6220],
        [96550, 0.24, 13293],
        [175100, 0.32, 32145],
        [219600, 0.35, 46385],
        [533800, 0.37, 156355],
    ];

    private const MARRIED_WITH_STEP_2 = [
        [0, 0.0, 0],
        [12550, 0.1, 0],
        [22500, 0.12, 995],
        [53075, 0.22, 4664],
        [98925, 0.24, 14751],
        [177475, 0.32, 33603],
        [221975, 0.35, 47843],
        [326700, 0.37, 84496.75],
    ];

    private const SINGLE_WITH_STEP_2 = [
        [0, 0.0, 0],
        [6275, 0.1, 0],
        [11250, 0.12, 497.5],
        [26538, 0.22, 2332],
        [49463, 0.24, 7375.5],
        [88738, 0.32, 16801.5],
        [110988, 0.35, 23921.5],
        [268075, 0.37, 78902.13],
    ];

    private const HEAD_OF_HOUSEHOLD_WITH_STEP_2 = [
        [0, 0.0, 0],
        [9400, 0.1, 0],
        [16500, 0.12, 710],
        [36500, 0.22, 3110],
        [52575, 0.24, 6646.5],
        [91850, 0.32, 16072.5],
        [114100, 0.35, 23192.5],
        [271200, 0.37, 78177.5],
    ];

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $tax_brackets = $this->getTaxBrackets();
        $adjusted_earnings = $this->getAdjustedEarnings();
        $tentative_withholding_amount = $this->getTaxAmountFromTaxBrackets($adjusted_earnings, $tax_brackets);

        $withholding_amount = max($tentative_withholding_amount - $this->getTaxCredit(), 0);
        $withholding_amount /= $this->payroll->pay_periods;
        $withholding_amount += $this->getAdditionalWithholding();

        $this->tax_total = $this->payroll->withholdTax($withholding_amount);
        return round(intval($this->tax_total * 100) / 100, 2);
    }

    public function getAdjustedEarnings(): float
    {
        $annual_wages = $this->payroll->getEarnings() * $this->payroll->pay_periods;
        if ($this->tax_information->form_version !== self::FORM_VERSION_2020) {
            $exemptions = $this->tax_information->exemptions * 4300;
            return max($annual_wages - $exemptions, 0);
        }

        $annual_wages += $this->tax_information->other_income;
        if ($this->tax_information->step_2_checked) {
            return $annual_wages;
        }

        $filing_married = $this->tax_information->filing_status === static::FILING_MARRIED
            || $this->tax_information->filing_status === static::FILING_JOINTLY;
        $deductions = $filing_married ? 12900 : 8600;
        return max($annual_wages - $deductions, 0);
    }

    public function getAdditionalWithholding(): float
    {
        $additional_withholding = $this->tax_information->form_version === self::FORM_VERSION_2020
            ? $this->tax_information->extra_withholding
            : $this->tax_information->additional_withholding;

        return max(min($this->payroll->getNetEarnings(), $additional_withholding), 0);
    }

    private function getTaxCredit(): float
    {
        return $this->tax_information->form_version === self::FORM_VERSION_2020
            ? $this->tax_information->dependents_deduction_amount ?? 0.0
            : 0.0;
    }

    public function getTaxBrackets(): array
    {
        if ($this->tax_information->form_version !== self::FORM_VERSION_2020) {
            return $this->taxBracketsEarlier();
        }

        return $this->tax_information->step_2_checked
            ? $this->taxBracketsWithStep2()
            : $this->taxBracketsWithoutStep2();
    }

    private function taxBracketsEarlier(): array
    {
        switch ($this->tax_information->filing_status) {
            case static::FILING_SINGLE:
            case static::FILING_SEPERATE:
            case static::FILING_HEAD_OF_HOUSEHOLD:
                return static::SINGLE_WITHOUT_STEP_2;
            case static::FILING_MARRIED:
            case static::FILING_JOINTLY:
                return static::MARRIED_WITHOUT_STEP_2;
            default:
                throw new Exception("Invalid filing status: {$this->tax_information->filing_status}");
        }
    }

    private function taxBracketsWithStep2(): array
    {
        switch ($this->tax_information->filing_status) {
            case static::FILING_SINGLE:
            case static::FILING_SEPERATE:
                return static::SINGLE_WITH_STEP_2;
            case static::FILING_MARRIED:
            case static::FILING_JOINTLY:
                return static::MARRIED_WITH_STEP_2;
            case static::FILING_HEAD_OF_HOUSEHOLD:
                return static::HEAD_OF_HOUSEHOLD_WITH_STEP_2;
            default:
                throw new Exception("Invalid filing status: {$this->tax_information->filing_status}");
        }
    }

    private function taxBracketsWithoutStep2(): array
    {
        switch ($this->tax_information->filing_status) {
            case static::FILING_SINGLE:
            case static::FILING_SEPERATE:
                return static::SINGLE_WITHOUT_STEP_2;
            case static::FILING_MARRIED:
            case static::FILING_JOINTLY:
                return static::MARRIED_WITHOUT_STEP_2;
            case static::FILING_HEAD_OF_HOUSEHOLD:
                return static::HEAD_OF_HOUSEHOLD_WITHOUT_STEP_2;
            default:
                throw new Exception("Invalid filing status: {$this->tax_information->filing_status}");
        }
    }
}