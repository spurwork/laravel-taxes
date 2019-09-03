<?php

namespace Appleton\Taxes\Countries\US\Vermont\VermontIncome\V20190101;

use Appleton\Taxes\Countries\US\Vermont\VermontIncome\VermontIncome as BaseVermontIncome;

class VermontIncome extends BaseVermontIncome
{
    private const SINGLE_BRACKETS = [
        [0, 0.0, 0],
        [3075, 0.0335, 0],
        [42675, 0.066, 1326.6],
        [99075, 0.076, 5049.0],
        [203275, 0.0875, 12968.2],
    ];

    private const MARRIED_BRACKETS = [
        [0, 0.0, 0],
        [9225, 0.0335, 0],
        [75375, 0.066, 2216.03],
        [169175, 0.076, 8406.83],
        [252975, 0.0875, 14775.63],
    ];

    private const ALLOWANCE_AMOUNT = 4250.0;
    private const SUPPLEMENTAL_TAX_RATE = 0.03;
    private const ADDITIONAL_WITHHOLDING_RATE = 0.3;

    protected function getSupplementalIncomeTaxRate(): float
    {
        return self::SUPPLEMENTAL_TAX_RATE;
    }

    protected function getAdditionalWithholdingRate(): float
    {
        return self::ADDITIONAL_WITHHOLDING_RATE;
    }

    protected function getAllowanceAmount(): float
    {
        return self::ALLOWANCE_AMOUNT;
    }

    protected function getMarriedBrackets(): array
    {
        return self::MARRIED_BRACKETS;
    }

    protected function getSingleBrackets(): array
    {
        return self::SINGLE_BRACKETS;
    }
}
