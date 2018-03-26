<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20180101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome as BaseGeorgiaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;

class GeorgiaIncome extends BaseGeorgiaIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.05;

    const SINGLE_BRACKETS = [
        [0, 0.01, 0],
        [750, 0.02, 7.5],
        [2250, 0.03, 37.5],
        [3750, 0.04, 82.5],
        [5250, 0.05, 142.5],
        [7000, 0.06, 230],
    ];

    const BOTH_WORKING_BRACKETS = [
        [0, 0.01, 0],
        [500, 0.02, 5],
        [1500, 0.03, 25],
        [2500, 0.04, 55],
        [3500, 0.05, 95],
        [5000, 0.06, 170],
    ];

    const SINGLE_WORKING_BRACKETS = [
        [0, 0.01, 0],
        [1000, 0.02, 10],
        [3000, 0.03, 50],
        [5000, 0.04, 110],
        [7000, 0.05, 190],
        [10000, 0.06, 340],
    ];

    const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => 2300,
        self::FILING_HEAD_OF_HOUSEHOLD => 2300,
        self::FILING_MARRIED_SEPARATE => 1500,
        self::FILING_MARRIED_JOINT_BOTH_WORKING => 1500,
        self::FILING_MARRIED_JOINT_ONE_WORKING => 3000,
    ];

    const PERSONAL_EXEMPTION_ALLOWANCES = [
        self::FILING_SINGLE => 2700,
        self::FILING_HEAD_OF_HOUSEHOLD => 2700,
        self::FILING_MARRIED_SEPARATE => 3700,
        self::FILING_MARRIED_JOINT_BOTH_WORKING => 3700,
        self::FILING_MARRIED_JOINT_ONE_WORKING => 3700,
    ];

    const DEPENDENT_ALLOWANCE_AMOUNT = 3000;

    public function __construct(GeorgiaIncomeTaxInformation $tax_information, FederalIncome $federal_income, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        $adjusted_earnings = $this->payroll->earnings * $this->payroll->pay_periods;

        if ($this->tax_information->filing_status != static::FILING_ZERO) {
            $adjusted_earnings = $adjusted_earnings - $this->getStandardDeduction() - $this->getPersonalAllowance() - $this->getDependentExemption();
        }

        return $adjusted_earnings;
    }

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === static::FILING_SINGLE || $this->tax_information->filing_status === static::FILING_HEAD_OF_HOUSEHOLD) {
            return static::SINGLE_BRACKETS;
        } else if ($this->tax_information->filing_status === static::FILING_MARRIED_JOINT_ONE_WORKING) {
            return static::SINGLE_WORKING_BRACKETS;
        } else {
            return static::BOTH_WORKING_BRACKETS;
        }
    }

    private function getStandardDeduction()
    {
        if (array_key_exists($this->tax_information->filing_status, static::STANDARD_DEDUCTIONS)) {
            return static::STANDARD_DEDUCTIONS[$this->tax_information->filing_status];
        }

        return 0;
    }

    private function getPersonalAllowance()
    {
        if ($this->tax_information->personal_allowances === 0 || !array_key_exists($this->tax_information->filing_status, static::PERSONAL_EXEMPTION_ALLOWANCES)) {
            return 0;
        }

        if ($this->tax_information->filing_status === static::FILING_MARRIED_JOINT_ONE_WORKING) {
            return static::PERSONAL_EXEMPTION_ALLOWANCES[$this->tax_information->filing_status] * $this->tax_information->personal_allowances;
        }

        return static::PERSONAL_EXEMPTION_ALLOWANCES[$this->tax_information->filing_status];
    }

    private function getDependentExemption()
    {
        return $this->tax_information->allowances * self::DEPENDENT_ALLOWANCE_AMOUNT;
    }
}