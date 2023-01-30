<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome as BaseAlabamaIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20170101\AlabamaIncome as AlabamaIncome2017;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;

class AlabamaIncome extends BaseAlabamaIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.05;

    const SINGLE_BRACKETS = AlabamaIncome2017::SINGLE_BRACKETS;

    const MARRIED_BRACKETS = AlabamaIncome2017::MARRIED_BRACKETS;

    const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => [
            'base' => 23499.99,
            'amount' => 2500,
            'floor' => 2000,
            'modifier' => [
                'amount' => 25,
                'per' => 500,
            ],
        ],
        self::FILING_SEPERATE => [
            'base' => 10749.99,
            'amount' => 3750,
            'floor' => 2000,
            'modifier' => [
                'amount' => 88,
                'per' => 250,
            ]
        ],
        self::FILING_MARRIED => [
            'base' => 23499.99,
            'amount' => 7500,
            'floor' => 4000,
            'modifier' => [
                'amount' => 175,
                'per' => 500,
            ]
        ],
        self::FILING_HEAD_OF_HOUSEHOLD => [
            'base' => 23499.99,
            'amount' => 4700,
            'floor' => 2000,
            'modifier' => [
                'amount' => 135,
                'per' => 500,
            ]
        ],
    ];

    const PERSONAL_EXEMPTION_ALLOWANCES = AlabamaIncome2017::PERSONAL_EXEMPTION_ALLOWANCES;

    const DEPENDENT_EXEMPTION_BRACKETS = AlabamaIncome2017::DEPENDENT_EXEMPTION_BRACKETS;

    public function __construct(AlabamaIncomeTaxInformation $tax_information, FederalIncome $federal_income, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }
}
