<?php

namespace Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

abstract class NorthCarolinaIncome extends BaseStateIncome
{
    const FILING_SINGLE = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_SEPERATE => 'FILING_SEPERATE',
    ];

    public function __construct(NorthCarolinaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    abstract public function getSupplementalTaxRate();

    abstract public function getTaxRate();

    abstract public function getStandardDeductions();

    abstract public function getDependentExemptionBrackets();

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $tax_amount = $this->getTaxAmountFromTaxBrackets($this->getAdjustedEarnings(), $this->getTaxBrackets())
            / $this->payroll->pay_periods;
        $this->tax_total = $this->payroll->withholdTax(round($tax_amount)) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(((int)($this->tax_total * 100)) / 100, 2);
    }

    public function getAdjustedEarnings()
    {
        return $this->getGrossEarnings() - $this->getStandardDeduction() - $this->getDependentExemption();
    }

    public function getSupplementalIncomeTax()
    {
        return $this->payroll->getSupplementalEarnings() * $this->getSupplementalTaxRate();
    }

    public function getTaxBrackets()
    {
        return [[0, $this->getTaxRate(), 0]];
    }

    private function getStandardDeduction()
    {
        $standard_deductions = $this->getStandardDeductions();
        if (array_key_exists($this->tax_information->filing_status, $standard_deductions)) {
            return $standard_deductions[$this->tax_information->filing_status];
        }

        return 0;
    }

    private function getDependentExemption()
    {
        $gross_earnings = $this->getGrossEarnings();
        $dependent_exemption = $this->getTaxBracket($gross_earnings, $this->getDependentExemptionBrackets()[$this->tax_information->filing_status]);
        return $this->tax_information->dependents * $dependent_exemption[1];
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings()) * $this->payroll->pay_periods;
    }
}
