<?php

namespace Appleton\Taxes\Countries\US\FederalIncome\V20170101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class FederalIncome extends BaseFederalIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.25;

    const EXEMPTION_AMOUNT = 4050;
    const NON_RESIDENT_ALIEN_AMOUNT = 2300;

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

    public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    public function getAdjustedEarnings()
    {
        return (($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings()) * $this->payroll->pay_periods) - ($this->tax_information->exemptions * static::EXEMPTION_AMOUNT) + ($this->tax_information->non_resident_alien ? static::NON_RESIDENT_ALIEN_AMOUNT : 0);
    }

    public function getTaxBrackets()
    {
        return ($this->tax_information->filing_status >= static::FILING_MARRIED) ? static::MARRIED_BRACKETS : static::SINGLE_BRACKETS;
    }
}
