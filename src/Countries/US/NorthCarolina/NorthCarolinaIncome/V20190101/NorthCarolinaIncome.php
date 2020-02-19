<?php

namespace Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\V20190101;

use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome as BaseNorthCarolinaIncome;

class NorthCarolinaIncome extends BaseNorthCarolinaIncome
{
    public const TAX_RATE = 0.0535;

    private const SUPPLEMENTAL_TAX_RATE = 0.0535;

    private const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => 10000,
        self::FILING_HEAD_OF_HOUSEHOLD => 15000,
        self::FILING_MARRIED => 10000,
        self::FILING_SEPERATE => 10000,
    ];

    private const DEPENDENT_EXEMPTION_BRACKETS = [
        self::FILING_SINGLE => [
            [0, 2500],
            [20000, 2000],
            [30000, 1500],
            [40000, 1000],
            [50000, 500],
            [60000, 0],
        ],
        self::FILING_HEAD_OF_HOUSEHOLD => [
            [0, 2500],
            [30000, 2000],
            [45000, 1500],
            [60000, 1000],
            [75000, 500],
            [90000, 0],
        ],
        self::FILING_MARRIED => [
            [0, 2500],
            [40000, 2000],
            [60000, 1500],
            [80000, 1000],
            [100000, 500],
            [120000, 0],
        ],
        self::FILING_SEPERATE => [
            [0, 2500],
            [20000, 2000],
            [30000, 1500],
            [40000, 1000],
            [50000, 500],
            [60000, 0],
        ],
    ];

    public function getSupplementalTaxRate(): float
    {
        return self::SUPPLEMENTAL_TAX_RATE;
    }

    public function getTaxRate(): float
    {
        return self::TAX_RATE;
    }

    public function getStandardDeductions(): array
    {
        return self::STANDARD_DEDUCTIONS;
    }

    public function getDependentExemptionBrackets(): array
    {
        return self::DEPENDENT_EXEMPTION_BRACKETS;
    }
}
