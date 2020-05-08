<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganIncome\V20200101;

use Appleton\Taxes\Countries\US\Michigan\MichiganIncome\MichiganIncome as BaseMichiganIncome;

class MichiganIncome extends BaseMichiganIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.0425;
    private const TAX_RATE = 0.0425;
    private const ANNUAL_ALLOWANCE_AMOUNT = 4750;

    public function getAdjustedEarnings()
    {
        return $this->payroll->getEarnings() * $this->payroll->pay_periods - self::ANNUAL_ALLOWANCE_AMOUNT * $this->tax_information->dependents;
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }
}
