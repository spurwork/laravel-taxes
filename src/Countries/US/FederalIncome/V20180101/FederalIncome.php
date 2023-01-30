<?php

namespace Appleton\Taxes\Countries\US\FederalIncome\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class FederalIncome extends BaseFederalIncome
{
    const SUPPLEMENTAL_TAX_RATE = 0.22;

    const EXEMPTION_AMOUNT = 4150;
    const NON_RESIDENT_ALIEN_AMOUNT = 7850;

    const SINGLE_BRACKETS = [
        [0, 0.0, 0],
        [3700, 0.1, 0],
        [13225, 0.12, 952.5],
        [42400, 0.22, 4453.50],
        [86200, 0.24, 14089.5],
        [161200, 0.32, 32089.5],
        [203700, 0.35, 45689.5],
        [503700, 0.37, 150689.5],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.0, 0],
        [11550, 0.1, 0],
        [30600, 0.12, 1905],
        [88950, 0.22, 8907],
        [176550, 0.24, 28179],
        [326550, 0.32, 64179],
        [411550, 0.35, 91379],
        [611550, 0.37, 161379],
    ];

    public function __construct(FederalIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($tax_information, $payroll);
        $this->tax_information = $tax_information;
    }

    public function compute(Collection $tax_areas): float
    {
        return $this->computePrior2020($tax_areas);
    }

    public function getAdjustedEarnings()
    {
        return (($this->payroll->getEarnings() - $this->payroll->getSupplementalEarnings()) * $this->payroll->pay_periods) - ($this->tax_information->exemptions * static::EXEMPTION_AMOUNT) + ($this->tax_information->non_resident_alien ? static::NON_RESIDENT_ALIEN_AMOUNT : 0);
    }

    public function getTaxBrackets(): array
    {
        return ($this->tax_information->filing_status === static::FILING_MARRIED) ? static::MARRIED_BRACKETS : static::SINGLE_BRACKETS;
    }
}
