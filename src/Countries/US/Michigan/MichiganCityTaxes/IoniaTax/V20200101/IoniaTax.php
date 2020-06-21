<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\IoniaTax\V20200101;

use Appleton\Taxes\Countries\US\Michigan\IoniaTax\IoniaTax as BaseIoniaTax;

class IoniaTax extends BaseIoniaTax
{
    public const RESIDENCY_TAX_RATE = 0.01;
    public const NONRESIDENCY_TAX_RATE = 0.005;
    public const EXEMPTION_AMOUNT = 700;


    protected static function getResidencyTaxRate(): float
    {
        return self::RESIDENCY_TAX_RATE;
    }

    protected static function getNonresidencyTaxRate(): float
    {
        return self::NONRESIDENCY_TAX_RATE;
    }

    protected static function getExemptionAmount(): int
    {
        return self::EXEMPTION_AMOUNT;
    }
}
