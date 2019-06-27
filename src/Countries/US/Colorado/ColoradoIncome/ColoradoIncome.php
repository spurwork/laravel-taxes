<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

abstract class ColoradoIncome extends BaseStateIncome
{
    const FILING_SINGLE = 1;
    const FILING_MARRIED = 2;

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'FILING_SINGLE',
        self::FILING_MARRIED => 'FILING_MARRIED',
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
        return round(parent::compute($tax_areas));
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
        return array_get($this->getExemptionAmounts(), min($this->tax_information->exemptions, 10));
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings())
            * $this->payroll->pay_periods;
    }
}
