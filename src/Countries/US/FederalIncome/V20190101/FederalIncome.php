<?php

namespace Appleton\Taxes\Countries\US\FederalIncome\V20190101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class FederalIncome extends BaseFederalIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.22;

    const EXEMPTION_AMOUNT = 4200;
    const NON_RESIDENT_ALIEN_AMOUNT = 7850;

    const SINGLE_BRACKETS = [
        [0, 0.0, 0],
        [3800, 0.1, 0],
        [13500, 0.12, 970],
        [43275, 0.22, 4543],
        [88000, 0.24, 14382.5],
        [164525, 0.32, 32748.5],
        [207900, 0.35, 46628.5],
        [514100, 0.37, 153798.5],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.0, 0],
        [11800, 0.1, 0],
        [31200, 0.12, 1940],
        [90750, 0.22, 9086],
        [180200, 0.24, 28765],
        [333250, 0.32, 65497],
        [420000, 0.35, 93257],
        [624150, 0.37, 164709.5],
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
        return ($this->tax_information->filing_status === static::FILING_MARRIED) ? static::MARRIED_BRACKETS : static::SINGLE_BRACKETS;
    }
}
