<?php

namespace Appleton\Taxes\Countries\US\Illinois\IllinoisIncome\V20200101;

use Appleton\Taxes\Countries\US\Illinois\IllinoisIncome\IllinoisIncome as BaseIllinoisIncome;

class IllinoisIncome extends BaseIllinoisIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.0495;

    private const BASIC_ALLOWANCE_AMOUNT = 2325;
    private const ADDITIONAL_ALLOWANCE_AMOUNT = 1000;

    public function getTaxBrackets()
    {
        return [[0, self::SUPPLEMENTAL_TAX_RATE, 0]];
    }

    public function getAdjustedEarnings(): int
    {
        $basic_allowances = self::BASIC_ALLOWANCE_AMOUNT
            * $this->tax_information->basic_allowances;
        $additional_allowances = self::ADDITIONAL_ALLOWANCE_AMOUNT
            * $this->tax_information->additional_allowances;

        $exemptions = ($basic_allowances + $additional_allowances) / $this->payroll->pay_periods;
        return ($this->payroll->getEarnings() - $exemptions) * $this->payroll->pay_periods;
    }
}
