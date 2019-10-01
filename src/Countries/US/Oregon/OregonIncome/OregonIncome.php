<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonIncome;

use Appleton\Taxes\Classes\BaseStateIncome;
use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;

abstract class OregonIncome extends BaseStateIncome
{
    const FILING_SINGLE = 'S';
    const FILING_MARRIED = 'M';

    const FILING_STATUSES = [
        self::FILING_SINGLE => 'Filing Single',
        self::FILING_MARRIED => 'Filing Married',
    ];

    const SINGLE_LESS_THAN_THREE_EXEMPTIONS_DEDUCTION = 2270;
    const SINGLE_THREE_OR_MORE_EXEMPTIONS_DEDUCTION = 4545;
    const MARRIED_DEDUCTION = 4545;

    const ANNUAL_TAX_CREDIT = 206;

    const SINGLE_MAXIMUM_FEDERAL_DEDUCTION = [
        [0, 6800],
        [124999.99, 5450],
        [129999.99, 4100],
        [134999.99, 2700],
        [139999.99, 1350],
        [144999.99, 0],
    ];

    const MARRIED_MAXIMUM_FEDERAL_DEDUCTION = [
        [0, 6800],
        [249999.99, 5450],
        [259999.99, 4100],
        [269999.99, 2700],
        [279999.99, 1350],
        [289999.99, 0],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_LESS_THEN_3_EXEMPTIONS_LESS_THAN_50000 = [
        [0, 0.05, 206],
        [3550, 0.07, 383.5],
        [8900, 0.09, 758],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_LESS_THAN_50000 = [
        [0, 0.05, 206],
        [7100, 0.07, 561],
        [17800, 0.09, 1310],
    ];

    const TAX_WITHHOLDING_TABLE_MARRIED_LESS_THAN_50000 = [
        [0, 0.05, 206],
        [7100, 0.07, 561],
        [17800, 0.09, 1310],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_LESS_THEN_3_EXEMPTIONS_MORE_THAN_50000 = [
        [0, 0, 0],
        [8900, 0.0, 552],
        [125000, 0.099, 11001],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_MORE_THAN_50000 = [
        [0, 0, 0],
        [17800, 0.09, 1104],
        [250000, 0.099, 22002],
    ];

    const TAX_WITHHOLDING_TABLE_MARRIED_MORE_THAN_50000 = [
        [0, 0, 0],
        [17800, 0.09, 1104],
        [250000, 0.099, 22002],
    ];


    public function __construct(FederalIncome $federal_income, OregonIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
        $this->federal_income_tax = $federal_income->getAmount();
    }
}
