<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Illuminate\Support\Arr;


abstract class AlabamaIncome extends BaseStateIncome
{
    const FILING_ZERO = 0;
    const FILING_SINGLE = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;

    const FILING_STATUSES = [
        self::FILING_ZERO => 'FILING_ZERO',
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_SEPERATE => 'FILING_SEPERATE',
    ];

    protected float $federal_income_tax;

    public function __construct(
        protected AlabamaIncomeTaxInformation $tax_information,
        Payroll                               $payroll,
    ) {
        parent::__construct($payroll);
    }

    public function getAdjustedEarnings()
    {
        return $this->payroll->getAnnualGross()
            - $this->getStandardDeduction()
            - $this->getFederalWithholding()
            - $this->getPersonalExemption()
            - $this->getDependentExemption();
    }

    public function getTaxBrackets(): array
    {
        return ($this->tax_information->isFilingMarried())
            ? static::MARRIED_BRACKETS
            : static::SINGLE_BRACKETS;
    }

    public function getStandardDeduction()
    {
        $gross_earnings = $this->payroll->getAnnualGross();
        $standard_deduction = static::STANDARD_DEDUCTIONS[$this->tax_information->getFilingStatus()];
        $deduction = $standard_deduction['amount'];

        if ($gross_earnings > $standard_deduction['base']) {
            $deduction -= $standard_deduction['modifier']['amount'] * ceil(($gross_earnings - $standard_deduction['base']) / $standard_deduction['modifier']['per']);
        }

        return max($deduction, $standard_deduction['floor']);
    }

    protected function getFederalWithholding(): float
    {
        return $this->federal_income_tax * $this->payroll->pay_periods;
    }

    protected function getPersonalExemption(): int
    {
        if ($this->tax_information->isFilingZero()) {
            return 0;
        }

        return Arr::get(
            static::PERSONAL_EXEMPTION_ALLOWANCES,
            $this->tax_information->getFilingStatus(),
            0,
        );
    }

    protected function getDependentExemption(): float
    {
        if (!$this->tax_information->hasDependents()) {
            return 0.0;
        }

        $dependent_bracket = $this->getTaxBracket(
            $this->payroll->getAnnualGross(),
            static::DEPENDENT_EXEMPTION_BRACKETS,
        );
        return $dependent_bracket[1] * $this->tax_information->getDependents();
    }
}
