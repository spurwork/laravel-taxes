<?php

namespace Appleton\Taxes\Countries\US\Virginia\VirginiaIncome\V20190101;

use Appleton\Taxes\Countries\US\Virginia\VirginiaIncome\VirginiaIncome as BaseVirginiaIncome;

class VirginiaIncome extends BaseVirginiaIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.0575;

    private const STANDARD_DEDUCTION_AMOUNT = 3000;
    private const EXEMPTION_ALLOWANCE_AMOUNT = 930;
    private const OVER_65_OR_BLIND_EXEMPTION_ALLOWANCE_AMOUNT = 800;

    // [min_amount, rate, amount_to_add]
    private const BRACKETS = [
        [0, 0.02, 0],
        [3000, 0.03, 60],
        [5000, 0.05, 120],
        [17000, 0.0575, 720],
    ];

    public function getTaxBrackets(): array
    {
        return static::BRACKETS;
    }

    public function getAdjustedEarnings()
    {
        $standard_exemption_allowance = self::EXEMPTION_ALLOWANCE_AMOUNT
            * $this->tax_information->exemptions;
        $over_65_or_blind_exemption_allowance = self::OVER_65_OR_BLIND_EXEMPTION_ALLOWANCE_AMOUNT
            * $this->tax_information->sixty_five_plus_or_blind_exemptions;

        $deduction = self::STANDARD_DEDUCTION_AMOUNT + $standard_exemption_allowance
            + $over_65_or_blind_exemption_allowance;

        $annual_earnings = $this->payroll->getEarnings() * $this->payroll->pay_periods;

        return $annual_earnings - $deduction;
    }
}