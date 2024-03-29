<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20170101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome as BaseAlabamaIncome;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;

class AlabamaIncome extends BaseAlabamaIncome
{
     const SUPPLEMENTAL_TAX_RATE = 0.05;

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
            'floor' => 2000,
            'modifier' => [
                'amount' => 25,
                'per' => 500,
            ],
        ],
        self::FILING_SEPERATE => [
            'base' => 10249.99,
            'amount' => 3750,
            'floor' => 2000,
            'modifier' => [
                'amount' => 88,
                'per' => 250,
            ]
        ],
        self::FILING_MARRIED => [
            'base' => 20499.99,
            'amount' => 7500,
            'floor' => 4000,
            'modifier' => [
                'amount' => 175,
                'per' => 500,
            ]
        ],
        self::FILING_HEAD_OF_HOUSEHOLD => [
            'base' => 20499.99,
            'amount' => 4700,
            'floor' => 2000,
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

    public function __construct(AlabamaIncomeTaxInformation $tax_information, FederalIncome $federal_income, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        $adjusted_earnings = $this->getGrossEarnings() - ($this->federal_income_tax * $this->payroll->pay_periods);

        if (!$this->tax_information->isFilingZero()) {
            $adjusted_earnings = $adjusted_earnings - $this->getStandardDeduction() - $this->getPersonalExemption() - $this->getDependentExemption();
        }

        return $adjusted_earnings;
    }

    private function getGrossEarnings(): float
    {
        return ($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings()) * $this->payroll->pay_periods;
    }
}
