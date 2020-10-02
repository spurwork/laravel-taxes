<?php

namespace Appleton\Taxes\Countries\US\California\CaliforniaIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\California\CaliforniaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

/**
 * Tax Calculation:
 * 1. If income less than low income exemption no tax
 * 2. Subtract estimated deduction from gross
 * 3. Subtract standard deduction from gross
 * 4. Use tax bracket
 * 5. Subtract exemption allowance
 */
abstract class CaliforniaIncome extends BaseStateIncome
{
    public const FILING_SINGLE = 'S';
    public const FILING_MARRIED = 'M';
    public const FILING_HEAD_OF_HOUSEHOLD = 'H';
    protected const FILING_MARRIED_TWO_OR_MORE_ALLOWANCES = 'M2+';

    public const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
    ];

    protected $tax_information;
    private $federal_tax_information;

    public function __construct(CaliforniaIncomeTaxInformation $tax_information,
                                FederalIncomeTaxInformation $federal_tax_information,
                                Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
        $this->federal_tax_information = $federal_tax_information;
    }

    public function compute(Collection $tax_areas): float
    {
        if ($this->isUserClaimingExemption()) {
            return 0.0;
        }

        $this->setFilingStatus();
        $this->setAllowances();

        $earnings = $this->payroll->getEarnings() * $this->payroll->pay_periods;
        if ($earnings <= $this->getLowIncomeExemptionAmount()) {
            return 0.0;
        }

        $taxable_income = $earnings - $this->getEstimatedDeductionAmount()
            - $this->getStandardDeductionAmount();

        $annual_tax_amount = max($this->getTaxAmountFromTaxBrackets($taxable_income, $this->getTaxBrackets())
            - $this->getExemptionAllowanceAmount(), 0);
        $pay_period_tax_amount = $annual_tax_amount / $this->payroll->pay_periods;

        $this->tax_total = $this->payroll->withholdTax($pay_period_tax_amount) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());
        return round(((int)($this->tax_total * 100)) / 100, 2);
    }

    public function getTaxBrackets(): array
    {
        switch ($this->tax_information->filing_status) {
            case self::FILING_SINGLE:
                return $this->getSingleTaxBrackets();
            case self::FILING_MARRIED:
                return $this->getMarriedTaxBrackets();
            case self::FILING_HEAD_OF_HOUSEHOLD:
                return $this->getHeadOfHouseholdTaxBrackets();
            default:
                return [[0, 0, 0]];
        }
    }

    abstract protected function getLowIncomeExemptions(): array;

    abstract protected function getStandardDeductions(): array;

    abstract protected function getExemptionAllowances(): array;

    abstract protected function getEstimatedDeductions(): array;

    abstract protected function getSingleTaxBrackets(): array;

    abstract protected function getMarriedTaxBrackets(): array;

    abstract protected function getHeadOfHouseholdTaxBrackets(): array;

    private function getLowIncomeExemptionAmount(): int
    {
        switch ($this->tax_information->filing_status) {
            case self::FILING_SINGLE:
            case self::FILING_HEAD_OF_HOUSEHOLD:
                return $this->getLowIncomeExemptions()[$this->tax_information->filing_status];
            case self::FILING_MARRIED:
                return $this->tax_information->allowances < 2
                    ? $this->getLowIncomeExemptions()[$this->tax_information->filing_status]
                    : $this->getLowIncomeExemptions()[self::FILING_MARRIED_TWO_OR_MORE_ALLOWANCES];
            default:
                return 0;
        }
    }

    private function getEstimatedDeductionAmount(): int
    {
        $amount = $this->tax_information->estimated_deductions <= 10
            ? $this->getEstimatedDeductions()[$this->tax_information->estimated_deductions]
            : $this->getEstimatedDeductions()[1] * $this->tax_information->estimated_deductions;
        return $amount;
    }

    private function getStandardDeductionAmount(): int
    {
        switch ($this->tax_information->filing_status) {
            case self::FILING_SINGLE:
            case self::FILING_HEAD_OF_HOUSEHOLD:
                return $this->getStandardDeductions()[$this->tax_information->filing_status];
            case self::FILING_MARRIED:
                return $this->tax_information->allowances < 2
                    ? $this->getStandardDeductions()[$this->tax_information->filing_status]
                    : $this->getStandardDeductions()[self::FILING_MARRIED_TWO_OR_MORE_ALLOWANCES];
            default:
                return 0;
        }
    }

    private function getExemptionAllowanceAmount(): float
    {
        $amount = $this->tax_information->allowances <= 10
            ? $this->getExemptionAllowances()[$this->tax_information->allowances]
            : $this->getExemptionAllowances()[1] * $this->tax_information->allowances;
        return $amount;
    }

    private function setFilingStatus(): void
    {
        if ($this->tax_information->filing_status !== null) {
            return;
        }

        if ($this->federal_tax_information->filing_status !== null) {
            switch ($this->federal_tax_information->filing_status) {
                case FederalIncome::FILING_SINGLE:
                    $this->tax_information->filing_status = self::FILING_SINGLE;
                    return;
                case FederalIncome::FILING_MARRIED:
                    $this->tax_information->filing_status = self::FILING_MARRIED;
                    return;
                case FederalIncome::FILING_HEAD_OF_HOUSEHOLD:
                    $this->tax_information->filing_status = self::FILING_HEAD_OF_HOUSEHOLD;
                    return;
            }
        }

        $this->tax_information->filing_status = self::FILING_SINGLE;
    }

    private function setAllowances(): void
    {
        if ($this->tax_information->allowances !== null) {
            return;
        }

        $this->tax_information->allowances = $this->federal_tax_information->exemptions;
    }
}
