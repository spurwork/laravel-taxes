<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\Detroit\V20200101;

use Appleton\Taxes\Countries\US\Michigan\Detroit\DetroitTax as BaseDetroitTax;

class DetroitTax extends BaseDetroitTax
{
    public const RESIDENCY_TAX_RATE = 0.024;
    public const NONRESIDENCY_TAX_RATE = 0.012;
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
