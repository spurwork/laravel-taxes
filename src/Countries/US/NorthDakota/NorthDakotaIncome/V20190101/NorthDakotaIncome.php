<?php

namespace Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaIncome\V20190101;

use Appleton\Taxes\Classes\Payroll;
use Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaIncome\NorthDakotaIncome as BaseNorthDakotaIncome;
use Appleton\Taxes\Models\Countries\US\NorthDakota\NorthDakotaIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

class NorthDakotaIncome extends BaseNorthDakotaIncome
{
    const EXEMPTION_ALLOWANCE = 4200;

    const SINGLE_TAX_WITHHOLDING_BRACKET = [
        [0, 0, 0],
        [4500, .011, 0],
        [43000, .0204, 423.5],
        [87000, .0227, 1321.1],
        [202000, .0264, 3931.6],
        [432000, .0290, 10003.6],
    ];

    const MARRIED_TAX_WITHHOLDING_BRACKET = [
        [0, 0, 0],
        [10400, .011, 0],
        [75000, .0204, 710.6],
        [141000, .0227, 2057],
        [252000, .0264, 4576.7],
        [440000, .0290, 9539.9],
    ];

    public function getTaxBrackets()
    {
        if ($this->tax_information->filing_status === 'S' || $this->tax_information->filing_status === 'H') {
            return self::SINGLE_TAX_WITHHOLDING_BRACKET;
        }

        return self::MARRIED_TAX_WITHHOLDING_BRACKET;
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->isUserClaimingExemption()) {
            return 0;
        }

        $this->tax_total = $this->payroll->withholdTax($this->getTaxAmountFromTaxBrackets($this->getGrossWages() - $this->getExemptionAllowance(), $this->getTaxBrackets()) / $this->payroll->pay_periods);

        return (int)round(intval($this->tax_total * 100) / 100, 0);
    }

    public function getGrossWages()
    {
        return $this->getAdjustedEarnings() * $this->payroll->pay_periods;
    }

    public function getExemptionAllowance()
    {
        return $this->tax_information->exemptions * self::EXEMPTION_ALLOWANCE;
    }
}
