<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\Springfield\V20200101;

use Appleton\Taxes\Countries\US\Michigan\Springfield\SpringfieldTax as BaseSpringfieldTax;

class SpringfieldTax extends BaseSpringfieldTax
{
    public const RESIDENCY_TAX_RATE = 0.01;
    public const NONRESIDENCY_TAX_RATE = 0.005;
    public const EXEMPTION_AMOUNT = 750;


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
