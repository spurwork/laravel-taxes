<?php

namespace Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\V20180101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaIncome\NorthCarolinaIncome as BaseNorthCarolinaIncome;
use Appleton\Taxes\Models\Countries\US\NorthCarolina\NorthCarolinaIncomeTaxInformation;

class NorthCarolinaIncome extends BaseNorthCarolinaIncome
{
    public const TAX_RATE = 0.05499;

    private const SUPPLEMENTAL_TAX_RATE = 0.05599;

    private const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => 8750,
        self::FILING_HEAD_OF_HOUSEHOLD => 14000,
        self::FILING_MARRIED => 17500,
        self::FILING_SEPERATE => 8750,
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
