<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\Oregon\OregonIncome\OregonIncome as BaseOregonIncome;
use Appleton\Taxes\Models\Countries\US\Oregon\OregonIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class OregonIncome extends BaseOregonIncome
{
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
        [0, 206, 0.05],
        [3550, 383.5, 0.07],
        [8900, 758, 0.09],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_LESS_THAN_50000 = [
        [0, 206, 0.05],
        [7100, 561, 0.07],
        [17800, 1310, 0.09],
    ];

    const TAX_WITHHOLDING_TABLE_MARRIED_LESS_THAN_50000 = [
        [0, 206, 0.05],
        [7100, 561, 0.07],
        [17800, 1310, 0.09],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_LESS_THEN_3_EXEMPTIONS_MORE_THAN_50000 = [
        [0, 0, 0],
        [8900, 552, 0.0],
        [125000, 11001, 0.099],
    ];

    const TAX_WITHHOLDING_TABLE_SINGLE_MORE_THAN_OR_3_EXEMPTIONS_MORE_THAN_50000 = [
        [0, 0, 0],
        [17800, 1104, 0.09],
        [250000, 22002, 0.099],
    ];

    const TAX_WITHHOLDING_TABLE_MARRIED_MORE_THAN_50000 = [
        [0, 0, 0],
        [17800, 1104, 0.09],
        [250000, 22002, 0.099],
    ];

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption() || $this->tax_information->filing_status === 'E') {
            return 0;
        }

        $gross_annual_wages = $this->getAdjustedEarnings();

        $annualized_taxable_wages = $this->getBracketAmount($gross_annual_wages, $this->getTaxBrackets());

        $gross_annual_wages -= $annualized_taxable_wages;

        if ($this->tax_information->filing_status === 'M') {
            $gross_annual_wages -= self::MARRIED_MAXIMUM_FEDERAL_DEDUCTION;
        } elseif ($this->tax_information->filing_status === 'S' && $this->tax_information->exemptions >= 3) {
            $gross_annual_wages -= self::SINGLE_THREE_OR_MORE_EXEMPTIONS_DEDUCTION;
        } else {
            $gross_annual_wages -= self::SINGLE_LESS_THAN_THREE_EXEMPTIONS_DEDUCTION;
        }

        // step 7 of the nfc usda page
        if ($this->getAdjustedEarnings() < 50000) {
        } else {
        }
    }

    // need method to reduse exemptions

    public function getGrossAnnualWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getTaxBrackets(): array
    {
        if ($this->tax_information->filing_status === 'S') {
            return self::SINGLE_MAXIMUM_FEDERAL_DEDUCTION;
        }

        return self::MARRIED_MAXIMUM_FEDERAL_DEDUCTION;
    }

    public function getBracketAmount($wages, $table)
    {
        $bracket = $this->getTaxBracket($wages, $table);

        return $bracket[1];
    }
}
