<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;
use Illuminate\Support\Arr;

abstract class GeorgiaIncome extends BaseStateIncome
{
    const FILING_ZERO = 0;
    const FILING_SINGLE = 1;
    const FILING_MARRIED_JOINT_BOTH_WORKING = 2;
    const FILING_MARRIED_JOINT_ONE_WORKING = 3;
    const FILING_MARRIED_SEPARATE = 4;
    const FILING_HEAD_OF_HOUSEHOLD = 5;

    const FILING_STATUSES = [
        self::FILING_ZERO => 'FILING_ZERO',
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED_JOINT_BOTH_WORKING => 'FILING_MARRIED_JOINT_BOTH_WORKING',
        self::FILING_MARRIED_JOINT_ONE_WORKING => 'FILING_MARRIED_JOINT_ONE_WORKING',
        self::FILING_MARRIED_SEPARATE => 'FILING_MARRIED_SEPARATE',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
    ];

    public function __construct(
        protected GeorgiaIncomeTaxInformation $tax_information,
        Payroll                               $payroll,
    ) {
        parent::__construct($payroll);
    }

    public function getAdjustedEarnings(): float
    {
        $adjusted_earnings = $this->getGrossEarnings();

        if ($this->tax_information->isFilingZero()) {
            return $adjusted_earnings;
        }

        return $adjusted_earnings
            - $this->getStandardDeduction()
            - $this->getPersonalAllowance()
            - $this->getDependentAllowance()
            - $this->getAdditionalAllowance();
    }

    public function getSupplementalIncomeTax(): int
    {
        $annual_income = $this->getGrossEarnings();

        foreach (static::SUPPLEMENTAL_TAX_BRACKETS as $bracket) {
            if ($annual_income >= $bracket[0]) {
                return $this->payroll->getSupplementalEarnings() * $bracket[1];
            }
        }

        return 0;
    }

    protected function getPersonalAllowance(): int
    {
        if (!$this->tax_information->hasPersonalAllowance()) {
            return 0;
        }

        $amount_per_filing_status = $this->tax_information->isFilingMarriedOneWorking()
        && $this->tax_information->hasSinglePersonalAllowance()
            ? self::FILING_MARRIED_SEPARATE
            : $this->tax_information->getFilingStatus();

        $amount_per = Arr::get(static::PERSONAL_EXEMPTION_ALLOWANCES, $amount_per_filing_status);
        $amount_max = Arr::get(static::PERSONAL_EXEMPTION_ALLOWANCES, $this->tax_information->getFilingStatus());

        return min($amount_per * $this->tax_information->getPersonalAllowance(), $amount_max);
    }

    protected function getDependentAllowance(): int
    {
        return $this->tax_information->getDependents() * static::DEPENDENT_ALLOWANCE_AMOUNT;
    }

    protected function getAdditionalAllowance(): int
    {
        return $this->tax_information->getAllowances() * static::DEPENDENT_ALLOWANCE_AMOUNT;
    }

    protected function getGrossEarnings(): float
    {
        return $this->payroll->getAnnualGross();
    }

    protected function getStandardDeduction(): int
    {
        return Arr::get(
            static::STANDARD_DEDUCTIONS,
            $this->tax_information->getFilingStatus(),
            0,
        );
    }


    public function getTaxBrackets(): array
    {
        return match ($this->tax_information->getFilingStatus()) {
            static::FILING_MARRIED_JOINT_ONE_WORKING, static::FILING_HEAD_OF_HOUSEHOLD => static::SINGLE_WORKING_BRACKETS,
            static::FILING_MARRIED_JOINT_BOTH_WORKING, static::FILING_MARRIED_SEPARATE => static::BOTH_WORKING_BRACKETS,
            default => static::SINGLE_BRACKETS,
        };
    }
}
