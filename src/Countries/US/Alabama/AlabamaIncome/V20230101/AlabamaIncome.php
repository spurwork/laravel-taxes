<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20230101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome as BaseAlabamaIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20170101\AlabamaIncome as AlabamaIncome2017;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;

class AlabamaIncome extends BaseAlabamaIncome
{
    const SUPPLEMENTAL_TAX_RATE = AlabamaIncome2017::SUPPLEMENTAL_TAX_RATE;
    const SINGLE_BRACKETS = AlabamaIncome2017::SINGLE_BRACKETS;
    const MARRIED_BRACKETS = AlabamaIncome2017::MARRIED_BRACKETS;
    const PERSONAL_EXEMPTION_ALLOWANCES = AlabamaIncome2017::PERSONAL_EXEMPTION_ALLOWANCES;

    const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => [
            'base' => 25999.99,
            'amount' => 3000,
            'floor' => 2500,
            'modifier' => [
                'amount' => 25,
                'per' => 500,
            ],
        ],
        self::FILING_ZERO => [
            'base' => 25999.99,
            'amount' => 3000,
            'floor' => 2500,
            'modifier' => [
                'amount' => 25,
                'per' => 500,
            ],
        ],
        self::FILING_SEPERATE => [
            'base' => 12999.99,
            'amount' => 4250,
            'floor' => 2500,
            'modifier' => [
                'amount' => 88,
                'per' => 250,
            ]
        ],
        self::FILING_MARRIED => [
            'base' => 25999.99,
            'amount' => 8500,
            'floor' => 5000,
            'modifier' => [
                'amount' => 175,
                'per' => 500,
            ]
        ],
        self::FILING_HEAD_OF_HOUSEHOLD => [
            'base' => 25999.99,
            'amount' => 5200,
            'floor' => 2500,
            'modifier' => [
                'amount' => 135,
                'per' => 500,
            ]
        ],
    ];

    const DEPENDENT_EXEMPTION_BRACKETS = [
        [0, 1000],
        [50000, 500],
        [100000, 300]
    ];

    public function __construct(
        AlabamaIncomeTaxInformation $tax_information,
        FederalIncome               $federal_income,
        Payroll                     $payroll,
    ) {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }
}
