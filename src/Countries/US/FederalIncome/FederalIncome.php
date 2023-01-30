<?php

namespace Appleton\Taxes\Countries\US\FederalIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Traits\HasIncome;
use Illuminate\Database\Eloquent\Collection;

abstract class FederalIncome extends BaseIncome
{
    const TYPE = 'federal';
    const FORM_VERSION_2019 = '2019';
    const FORM_VERSION_2020 = '2020';

    const FILING_SINGLE = 0;
    const FILING_WIDOW = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;
    const FILING_JOINTLY = 5;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_WIDOW => 'FILING_WIDOW',
        self::FILING_HEAD_OF_HOUSEHOLD => 'FILING_HEAD_OF_HOUSEHOLD',
        self::FILING_MARRIED => 'FILING_MARRIED',
        self::FILING_SEPERATE => 'FILING_SEPERATE',
        self::FILING_JOINTLY => 'FILING_JOINTLY',
    ];

    public FederalIncomeTaxInformation $tax_information;

    public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function compute(Collection $tax_areas): float
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $this->tax_total = $this->payroll->withholdTax(
            $this->withholdingAmount($this->adjustedAnnualWages())
            - $this->taxCredits()
            + $this->tax_information->getExtraWithholding(),
        );

        return round(intval($this->tax_total * 100) / 100, 2);
    }

    public function getTaxBrackets(): array
    {
        return [];
    }

    protected function computePrior2020(Collection $tax_areas): float
    {
        return parent::compute($tax_areas);
    }

    protected function adjustedWages2020(): float
    {
        $adjusted_wages = $this->payroll->getAnnualGross()
            + $this->tax_information->getOtherIncome()
            - $this->tax_information->getDeductions();

        if ($this->tax_information->isStep2Checked()) {
            return $adjusted_wages;
        }

        return $adjusted_wages - $this->step2Credit();
    }

    protected function step2Credit(): int
    {
        return $this->tax_information->isFilingMarriedJointly()
            ? static::CREDIT_STEP_2_MARRIED
            : static::CREDIT_STEP_2_NOT_MARRIED;
    }

    protected function adjustedWagesPrior2020(): float
    {
        return $this->payroll->getAnnualGross()
            - bcmul($this->tax_information->getExemptions(), static::CREDIT_VERSION_PRIOR_2020);
    }

    protected function adjustedAnnualWages(): float
    {
        $wages = $this->tax_information->is2020Version()
            ? $this->adjustedWages2020()
            : $this->adjustedWagesPrior2020();

        return max($wages, 0);
    }

    protected function withholdingAmount(int $adjusted_annual_wages): float
    {
        $bracket_amount = $this->bracketAmount($adjusted_annual_wages, $this->bracket());

        return round($bracket_amount / $this->payroll->pay_periods, 2);
    }

    protected function bracket(): array
    {
        return $this->tax_information->is2020Version()
            ? $this->tax_information->isStep2Checked()
                ? $this->bracket2020Step2()
                : $this->bracket2020NotStep2()
            : $this->bracketPrior2020();
    }

    protected function bracketPrior2020(): array
    {
        return match ($this->tax_information->getFilingStatus()) {
            static::FILING_MARRIED => static::BRACKETS_MARRIED,
            default => static::BRACKETS_SINGLE,
        };
    }

    protected function bracket2020NotStep2(): array
    {
        return match ($this->tax_information->getFilingStatus()) {
            static::FILING_JOINTLY => static::BRACKETS_MARRIED,
            static::FILING_HEAD_OF_HOUSEHOLD => static::BRACKETS_HEAD_OF_HOUSEHOLD,
            default => static::BRACKETS_SINGLE,
        };
    }

    protected function bracket2020Step2(): array
    {
        return match ($this->tax_information->getFilingStatus()) {
            static::FILING_JOINTLY => static::BRACKETS_MARRIED_STEP_2,
            static::FILING_HEAD_OF_HOUSEHOLD => static::BRACKETS_HEAD_OF_HOUSEHOLD_STEP_2,
            default => static::BRACKETS_SINGLE_STEP_2,
        };
    }

    protected function bracketAmount($wages, $table): float
    {
        $bracket = $this->getTaxBracket($wages, $table);
        $tax_amount = isset($bracket) ? ($wages - $bracket[0]) * $bracket[1] + $bracket[2] : 0;

        return max($tax_amount, 0);
    }

    protected function taxCredits(): float
    {
        if (!$this->tax_information->is2020Version()) {
            return 0;
        }

        $value = round(
            $this->tax_information->getDependentsDeductionAmount() / $this->payroll->pay_periods,
            2,
        );

        return max($value, 0);
    }
}
