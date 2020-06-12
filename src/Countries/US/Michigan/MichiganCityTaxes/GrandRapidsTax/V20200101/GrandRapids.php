<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\GrandRapids\V20200101;

use Appleton\Taxes\Countries\US\Michigan\GrandRapids\GrandRapidsTax as BaseGrandRapidsTax;

class GrandRapidsTax extends BaseGrandRapidsTax
{
    public const RESIDENCY_TAX_RATE = 0.015;
    public const NONRESIDENCY_TAX_RATE = 0.0075;
    public const EXEMPTION_AMOUNT = 600;


    protected function getResidencyTaxRate(): float
    {
        return self::RESIDENCY_TAX_RATE;
    }

    protected function getNonResidencyTaxRate(): float
    {
        return self::NONRESIDENCY_TAX_RATE;
    }

    protected function getExemptionAmount(): float
    {
        return self::EXEMPTION_AMOUNT;
    }
}
