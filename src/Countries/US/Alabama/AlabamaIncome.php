<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasTaxBrackets;
use Appleton\Taxes\Traits\WithExemptions;
use Appleton\Taxes\Traits\WithFederalIncomeTax;
use Appleton\Taxes\Traits\WithFilingStatus;
use Appleton\Taxes\Traits\WithPayPeriods;

class AlabamaIncome extends BaseTax
{
    use HasTaxBrackets, WithExemptions, WithFederalIncomeTax, WithFilingStatus, WithPayPeriods;

    const TYPE = 'state';
    const WITHHELD = true;

    const FILING_SINGLE = 0;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;

    const SINGLE_BRACKETS = [
        [0, 0.02, 0],
        [500, 0.04, 10],
        [3000, 0.05, 110],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.02, 0],
        [1000, 0.04, 20],
        [6000, 0.05, 220],
    ];

    const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => [
            'base' => 20499.99,
            'amount' => 2500,
            'modifier' => [
                'amount' => 25,
                'per' => 500,
            ],
        ],
        self::FILING_SEPERATE => [
            'base' => 10249.99,
            'amount' => 3750,
            'modifier' => [
                'amount' => 88,
                'per' => 250,
            ]
        ],
        self::FILING_MARRIED => [
            'base' => 20499.99,
            'amount' => 7500,
            'modifier' => [
                'amount' => 175,
                'per' => 500,
            ]
        ],
        self::FILING_HEAD_OF_HOUSEHOLD => [
            'base' => 20499.99,
            'amount' => 4700,
            'modifier' => [
                'amount' => 135,
                'per' => 500,
            ]
        ],
    ];

    const PERSONAL_EXEMPTION_ALLOWANCES = [
        self::FILING_SINGLE => 1500,
        self::FILING_HEAD_OF_HOUSEHOLD => 3000,
        self::FILING_MARRIED => 3000,
        self::FILING_SEPERATE => 1500,
    ];

    const DEPENDENT_EXEMPTION_BRACKETS = [
        [0, 1000],
        [20000, 500],
        [100000, 300]
    ];

    private function getDependentExemption()
    {
        $gross_earnings = $this->getGrossEarnings();
        $dependent_exemption = $this->getTaxBracket($gross_earnings, self::DEPENDENT_EXEMPTION_BRACKETS);
        return $dependent_exemption[1] * $this->exemptions();
    }

    private function getPersonalExemptionAllowance()
    {
        return array_key_exists($this->filingStatus(), self::PERSONAL_EXEMPTION_ALLOWANCES) ? self::PERSONAL_EXEMPTION_ALLOWANCES[$this->filingStatus()] : 0;
    }

    private function getStandardDeducation()
    {
        return self::STANDARD_DEDUCTIONS[$this->filingStatus()];
    }

    private function getPersonalDeducation()
    {
        $gross_earnings = $this->getGrossEarnings();
        $standard_deduction = $this->getStandardDeducation();

        $deduction = $standard_deduction['amount'];

        if ($gross_earnings > $standard_deduction['base']) {
            $deduction -= $standard_deduction['modifier'] * (($gross_earnings - $standard_deduction['base']) / $standard_deduction['per']);
        }

        return $deduction;
    }

    private function getGrossEarnings()
    {
       return $this->earnings() * $this->payPeriods();
    }

    private function getAdjustedEarnings()
    {
        return ($this->earnings() * $this->payPeriods()) - ($this->federalIncomeTax() * $this->payPeriods()) - $this->getPersonalDeducation() - $this->getPersonalExemptionAllowance() - $this->getDependentExemption();
    }

    private function getTaxBrackets()
    {
        return ($this->filingStatus() >= self::FILING_MARRIED) ? self::MARRIED_BRACKETS : self::SINGLE_BRACKETS;
    }

    public function compute()
    {
        $adjusted_earnings = $this->getAdjustedEarnings();

        $tax_brackets = $this->getTaxBrackets();

        return round($this->getTaxAmountFromTaxBrackets($adjusted_earnings, $tax_brackets) / $this->payPeriods(), 2);
    }
}
