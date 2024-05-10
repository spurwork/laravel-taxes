<?php

namespace Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\V20240101;

use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\WashingtonDCIncome as BaseWashingtonDCIncome;

class WashingtonDCIncome extends BaseWashingtonDCIncome
{
    private const TAX_BRACKETS = [
        [0, .04, 0],
        [10000, .06, 400],
        [40000, .065, 2200],
        [60000, .085, 3500],
        [250000, .0925, 19650],
        [500000, .0975, 42775],
        [10000000, .1075, 91525],
    ];

    private const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => 13850,
        self::FILING_MARRIED_FILING_JOINTLY => 27700,
        self::FILING_MARRIED_FILING_SEPARATELY => 13850,
        self::FILING_HEAD_OF_HOUSEHOLD => 20800,
    ];

    public function getAdjustedEarnings()
    {
        return ($this->payroll->getEarnings() * $this->payroll->pay_periods)
            - $this->getStandardDeduction();
    }

    public function getStandardDeduction()
    {
        return self::STANDARD_DEDUCTIONS[$this->tax_information->filing_status];
    }

    public function getTaxBrackets()
    {
        return self::TAX_BRACKETS;
    }
}
