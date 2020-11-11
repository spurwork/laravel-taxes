<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\SpringfieldTax\V20200101;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\SpringfieldTax\SpringfieldTax as BaseSpringfieldTax;

class SpringfieldTax extends BaseSpringfieldTax
{
    public const RESIDENCY_TAX_RATE = 0;
    public const NONRESIDENCY_TAX_RATE = 0;
    public const EXEMPTION_AMOUNT = 0;

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
