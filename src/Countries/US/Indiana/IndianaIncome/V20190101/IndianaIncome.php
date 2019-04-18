<?php

namespace Appleton\Taxes\Countries\US\Indiana\IndianaIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\IndianaIncome\IndianaIncome as BaseIndianaIncome;

class IndianaIncome extends BaseIndianaIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.0323;

    private const PERSONAL_EXEMPTION_AMOUNTS = 1000;
    private const DEPENDENT_EXEMPTION_AMOUNT = 1500;
    private const TAX_RATE = 0.0323;

    public function getTaxBrackets(): array
    {
        return [[0, self::TAX_RATE, 0]];
    }

    public function getAdjustedEarnings(): int
    {
        $personal_allowances = self::PERSONAL_EXEMPTION_AMOUNTS * $this->tax_information->personal_exemptions;
        $dependent_allowances = self::DEPENDENT_EXEMPTION_AMOUNT * $this->tax_information->dependent_exemptions;

        $exemptions = ($personal_allowances + $dependent_allowances) / $this->payroll->pay_periods;
        return ($this->payroll->getEarnings() - $exemptions) * $this->payroll->pay_periods;
    }
}
