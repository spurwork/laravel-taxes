<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkCity\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\NewYork\NewYorkCity\NewYorkCity as BaseNewYorkCity;
use Appleton\Taxes\Countries\US\NewYork\NewYorkIncome\NewYorkIncome;
use Appleton\Taxes\Models\Countries\US\NewYork\NewYorkIncomeTaxInformation;

class NewYorkCity extends BaseNewYorkCity
{
    const SUPPLEMENTAL_TAX_RATE = 0.0425;

    const BRACKETS = [
        [0, 0.0205, 0],
        [8000, 0.0280, 164],
        [8700, 0.0325, 184],
        [15000, 0.0395, 388],
        [25000, 0.0415, 783],
        [60000, 0.0425, 2236],
    ];

    const SINGLE_DEDUCTION_ALLOWANCE_AMOUNT = 5000;

    const MARRIED_DEDUCTION_ALLOWANCE_AMOUNT = 5500;

    const EXEMPTION_ALLOWANCE_AMOUNT = 1000;

    public function __construct(NewYorkIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        return $this->getGrossEarnings() - $this->getExemptionAllowance() - $this->getDeductionAllowance();
    }

    public function getTaxBrackets()
    {
        return static::BRACKETS;
    }

    public function getAdditionalWithholding()
    {
        return max(min($this->payroll->getNetEarnings(), $this->tax_information->nyc_additional_withholding), 0);
    }

    private function getExemptionAllowance()
    {
        return $this->tax_information->nyc_allowances * static::EXEMPTION_ALLOWANCE_AMOUNT;
    }

    public function getDeductionAllowance()
    {
        if ($this->tax_information->filing_status === NewYorkIncome::FILING_SINGLE) {
            return static::SINGLE_DEDUCTION_ALLOWANCE_AMOUNT;
        } else {
            return static::MARRIED_DEDUCTION_ALLOWANCE_AMOUNT;
        }
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings()) * $this->payroll->pay_periods;
    }
}
