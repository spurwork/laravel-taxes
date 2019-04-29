<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganIncome\V20190101;

use Appleton\Taxes\Countries\US\Michigan\MichiganIncome\MichiganIncome as BaseMichiganIncome;

class MichiganIncome extends BaseMichiganIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.0425;
    private const TAX_RATE = 0.0425;
    private const ANNUAL_ALLOWANCE_AMOUNT = 4400;

    public function getAdjustedEarnings()
    {
        $this->gross_annual_wages = $this->payroll->getEarnings() * $this->payroll->pay_periods;

        $this->exemption_allowance = self::ANNUAL_ALLOWANCE_AMOUNT * $this->tax_information->dependents;

        $this->taxable_wages = ($this->gross_annual_wages - $this->exemption_allowance);

        return $this->taxable_wages;
    }

    public function getTaxBrackets()
    {
        return [[0, self::TAX_RATE, 0]];
    }
}
