<?php

namespace Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome as BaseNorthCarolinaIncome;
use Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation;

class NorthCarolinaIncome extends BaseNorthCarolinaIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.05599;

    const TAX_RATE = 0.0535;

    const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => 10000,
        self::FILING_HEAD_OF_HOUSEHOLD => 14000,
        self::FILING_MARRIED => 17500,
        self::FILING_SEPERATE => 8750,
    ];

    const DEPENDENT_EXEMPTION_BRACKETS = [
        self::FILING_SINGLE => [
            [0, 2500],
            [20000, 2000],
            [30000, 1500],
            [40000, 1000],
            [50000, 500],
            [60000, 0],
        ],
        self::FILING_HEAD_OF_HOUSEHOLD => [
            [0, 2500],
            [30000, 2000],
            [45000, 1500],
            [60000, 1000],
            [75000, 500],
            [90000, 0],
        ],
        self::FILING_MARRIED => [
            [0, 2500],
            [40000, 2000],
            [60000, 1500],
            [80000, 1000],
            [100000, 500],
            [120000, 0],
        ],
        self::FILING_SEPERATE => [
            [0, 2500],
            [20000, 2000],
            [30000, 1500],
            [40000, 1000],
            [50000, 500],
            [60000, 0],
        ],
    ];

    public function __construct(NorthCarolinaIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        return $this->getGrossEarnings() - $this->getStandardDeduction() - $this->getDependentExemption();
    }

    public function getSupplementalIncomeTax()
    {
        $annual_income = $this->getGrossEarnings();

        return $this->payroll->supplemental_earnings * self::SUPPLEMENTAL_TAX_RATE;
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }

    private function getStandardDeduction()
    {
        if (array_key_exists($this->tax_information->filing_status, static::STANDARD_DEDUCTIONS)) {
            return static::STANDARD_DEDUCTIONS[$this->tax_information->filing_status];
        }

        return 0;
    }

    private function getDependentExemption()
    {
        $gross_earnings = $this->getGrossEarnings();
        $dependent_exemption = $this->getTaxBracket($gross_earnings, static::DEPENDENT_EXEMPTION_BRACKETS[$this->tax_information->filing_status]);
        return $this->tax_information->allowances * $dependent_exemption[1];
    }

    private function getGrossEarnings()
    {
        return ($this->payroll->earnings - $this->payroll->supplemental_earnings) * $this->payroll->pay_periods;
    }
}
