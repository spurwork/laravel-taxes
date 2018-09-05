<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome as BaseNewMexicoIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;

class NewMexicoIncome extends BaseNewMexicoIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.049;

    const SINGLE_BRACKETS = [
        [0, 0.00, 0],
        [2300, 0.017, 0],
        [7800, 0.032, 93.5],
        [13300, 0.047, 269.5],
        [18300, 0.049, 504.5],
        [28300, 0.049, 994.5],
        [44300, 0.049, 1778.5],
        [67300, 0.049, 2905.5],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.00, 0],
        [8650, 0.017, 0],
        [16650, 0.032, 136],
        [24650, 0.047, 392],
        [32650, 0.047, 768],
        [48650, 0.049, 1552],
        [72650, 0.049, 2728],
        [108650, 0.049, 4492],
    ];

    const EXEMPTION_ALLOWANCE_AMOUNT = 4050;

    public function __construct(NewMexicoIncomeTaxInformation $tax_information, FederalIncome $federal_income, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        return $this->getGrossEarnings() - ($this->federal_income_tax * $this->payroll->pay_periods) - $this->getAllowanceExemption();
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === static::FILING_SINGLE || $this->tax_information->filing_status === static::FILING_HEAD_OF_HOUSEHOLD) {
            return static::SINGLE_BRACKETS;
        } else {
            return static::MARRIED_BRACKETS;
        }
    }

    private function getAllowanceExemption()
    {
        return $this->tax_information->exemptions * self::EXEMPTION_ALLOWANCE_AMOUNT;
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->earnings - $this->payroll->supplemental_earnings) * $this->payroll->pay_periods;
    }
}
