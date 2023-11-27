<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20240101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome as BaseAlabamaIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20170101\AlabamaIncome as AlabamaIncome2017;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\V20230101\AlabamaIncome as AlabamaIncome2023;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;

class AlabamaIncome extends BaseAlabamaIncome
{
    const SUPPLEMENTAL_TAX_RATE = AlabamaIncome2017::SUPPLEMENTAL_TAX_RATE;
    const SINGLE_BRACKETS = AlabamaIncome2017::SINGLE_BRACKETS;
    const MARRIED_BRACKETS = AlabamaIncome2017::MARRIED_BRACKETS;
    const PERSONAL_EXEMPTION_ALLOWANCES = AlabamaIncome2017::PERSONAL_EXEMPTION_ALLOWANCES;
    const STANDARD_DEDUCTIONS = AlabamaIncome2023::STANDARD_DEDUCTIONS;
    const DEPENDENT_EXEMPTION_BRACKETS = AlabamaIncome2023::DEPENDENT_EXEMPTION_BRACKETS;

    public function __construct(
        AlabamaIncomeTaxInformation $tax_information,
        FederalIncome               $federal_income,
        Payroll                     $payroll,
    ) {
        parent::__construct($tax_information, $payroll);
        $this->federal_income_tax = $federal_income->getAmount();
        $this->tax_information = $tax_information;
    }

    public function getAnnualGross(): float
    {
        return $this->payroll->getAnnualRegularGross();
    }
}
