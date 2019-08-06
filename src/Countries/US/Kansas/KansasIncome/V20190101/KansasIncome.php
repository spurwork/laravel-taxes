<?php

namespace Appleton\Taxes\Countries\US\Kansas\KansasIncome\V20190101;

use Appleton\Taxes\Countries\US\Kansas\KansasIncome\KansasIncome as BaseKansasIncome;

class KansasIncome extends BaseKansasIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0.05;

    private const ALLOWANCE_EXEMPTION = 2250;

    private const SINGLE_BRACKETS = [
        [0, 0, 0],
        [3000, 0.031, 0],
        [18000, 0.0525, 465],
        [33000, 0.057, 1252.5],
    ];

    private const MARRIED_BRACKETS = [
        [0, 0, 0],
        [7500, 0.031, 0],
        [37500, 0.0525, 930],
        [67500, 0.057, 2505],
    ];

    public function getTaxBrackets(): array
    {
        return $this->tax_information->allowance_rate === static::ALLOWANCE_RATE_SINGLE
            ? static::SINGLE_BRACKETS : static::MARRIED_BRACKETS;
    }

    public function getAdjustedEarnings()
    {
        $adjusted_earnings = $this->payroll->getEarnings() * $this->payroll->pay_periods
            - (self::ALLOWANCE_EXEMPTION * $this->tax_information->total_allowances);

        return max($adjusted_earnings, 0);
    }
}
