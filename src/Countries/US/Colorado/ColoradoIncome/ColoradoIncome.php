<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoIncome;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateIncome;
use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

abstract class ColoradoIncome extends BaseStateIncome
{
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

    public function __construct(ColoradoIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    abstract protected function getExemptionAmounts(): array;

    abstract protected function getSingleBracket(): array;

    abstract protected function getMarriedBracket(): array;

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0.00;
        }

        $tax_amount = round($this->getTaxAmountFromTaxBrackets($this->getAdjustedEarnings(), $this->getTaxBrackets())
            / $this->payroll->pay_periods);
        $this->tax_total = $this->payroll->withholdTax($tax_amount) +
            $this->payroll->withholdTax($this->getSupplementalIncomeTax()) +
            $this->payroll->withholdTax($this->getAdditionalWithholding());

        return round(((int)($this->tax_total * 100)) / 100, 2);
    }

    public function getAdjustedEarnings()
    {
        return $this->getGrossEarnings() - $this->getExemptionAllowance();
    }

    public function getSupplementalIncomeTax()
    {
        return 0;
    }

    public function getTaxBrackets(): array
    {
        return $this->tax_information->filing_status === static::FILING_MARRIED
            ? $this->getMarriedBracket()
            : $this->getSingleBracket();
    }

    private function getExemptionAllowance()
    {
        return Arr::get($this->getExemptionAmounts(), min($this->tax_information->exemptions, 10));
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings())
            * $this->payroll->pay_periods;
    }
}
