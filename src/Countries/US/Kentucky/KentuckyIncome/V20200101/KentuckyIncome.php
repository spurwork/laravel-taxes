<?php

namespace Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome\V20200101;

use Appleton\Taxes\Countries\US\Kentucky\KentuckyIncome\KentuckyIncome as BaseKentuckyIncome;

class KentuckyIncome extends BaseKentuckyIncome
{
    public const SUPPLEMENTAL_TAX_RATE = 0;

    public const TAX_RATE = 0.05;
    private const STANDARD_DEDUCTION = 2650;

    protected function getTaxRate(): float
    {
        return self::TAX_RATE;
    }

    protected function getStandardDeduction(): int
    {
        return self::STANDARD_DEDUCTION;
    }
}
