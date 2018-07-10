<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Colorado\ColoradoIncome\ColoradoIncome as BaseColoradoIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;

class ColoradoIncome extends BaseColoradoIncome
{
    const SINGLE_BRACKETS = [
        [0, 0, 0],
        [2300, 0.0463, 0],
    ];

    const MARRIED_BRACKETS = [
        [0, 0, 0],
        [8650, 0.0463, 0],
    ];

    const EXEMPTION_AMOUNTS = [
        0 => 0,
        1 => 4050,
        2 => 8100,
        3 => 12150,
        4 => 16200,
        5 => 20250,
        6 => 24300,
        7 => 22950,
        8 => 21600,
        9 => 20250,
        10 => 18900,
    ];

    public function __construct(ColoradoIncomeTaxInformation $tax_information, FederalIncome $federal_income, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }

    public function compute()
    {
        $amount = parent::compute();

        return round($amount, 0);
    }

    public function getAdjustedEarnings()
    {
        $adjusted_earnings = $this->getGrossEarnings() - $this->getExemptionAllowance();

        return $adjusted_earnings;
    }

    public function getSupplementalIncomeTax()
    {
        return 0;
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === static::FILING_MARRIED) {
            return static::MARRIED_BRACKETS;
        }

        return static::SINGLE_BRACKETS;
    }

    private function getExemptionAllowance()
    {
        if ($this->tax_information->exemptions >= 10) {
            return static::EXEMPTION_AMOUNTS[10];
        }

        return array_get(static::EXEMPTION_AMOUNTS, $this->tax_information->exemptions);
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->earnings - $this->payroll->supplemental_earnings) * $this->payroll->pay_periods;
    }
}
