<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Classes\BaseTax;
use Appleton\Taxes\Traits\HasSupplementalWagesTaxRate;
use Appleton\Taxes\Traits\HasTaxBrackets;
use Appleton\Taxes\Traits\WithExemptions;
use Appleton\Taxes\Traits\WithFilingStatus;
use Appleton\Taxes\Traits\WithNonResidentAlien;
use Appleton\Taxes\Traits\WithPayPeriods;
use Appleton\Taxes\Traits\WithSupplementalWages;

class FederalIncome extends BaseTax
{
    use HasSupplementalWagesTaxRate, HasTaxBrackets, WithExemptions, WithFilingStatus, WithNonResidentAlien, WithPayPeriods, WithSupplementalWages;

    const TYPE = 'federal';
    const WITHHELD = true;

    const FILING_SINGLE = 0;
    const FILING_WIDOW = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;

    const SUPPLEMENTAL_WAGES_TAX_RATE = 0.25;

    const EXEMPTION_AMOUNT = 4050;
    const NON_RESIDENT_ALIEN_AMOUNT = 2250;

    const SINGLE_BRACKETS = [
        [0, 0.0, 0],
        [2300, 0.1, 0],
        [11625, 0.15, 932.5],
        [40250, 0.25, 5226.25],
        [94200, 0.28, 18713.75],
        [193950, 0.33, 46643.75],
        [419000, 0.35, 120910.25],
        [420700, 0.396, 121505.25],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.0, 0],
        [8650, 0.1, 0],
        [27300, 0.15, 1885],
        [84550, 0.25, 10452.5],
        [161750, 0.28, 29752.5],
        [242000, 0.33, 52222.5],
        [425350, 0.35, 112728],
        [479350, 0.396, 131628],
    ];

    private function getAdjustedEarnings()
    {
        return ($this->earnings() * $this->payPeriods()) - ($this->exemptions() * self::EXEMPTION_AMOUNT) + ($this->nonResidentAlien() ? self::NON_RESIDENT_ALIEN_AMOUNT : 0);
    }

    private function getTaxBrackets()
    {
        return ($this->filingStatus() >= self::FILING_MARRIED) ? self::MARRIED_BRACKETS : self::SINGLE_BRACKETS;
    }

    public function compute()
    {
        $adjusted_earnings = $this->getAdjustedEarnings();

        $tax_brackets = $this->getTaxBrackets();

        return round($this->getTaxAmountFromTaxBrackets($adjusted_earnings, $tax_brackets) / $this->payPeriods() + $this->getSupplementalWagesTax(), 2);
    }
}
