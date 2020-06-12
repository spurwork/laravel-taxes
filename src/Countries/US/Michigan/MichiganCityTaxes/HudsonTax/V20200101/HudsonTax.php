<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\Hudson\V20200101;

use Appleton\Taxes\Countries\US\Michigan\Hudson\HudsonTax as BaseHudsonTax;

class HudsonTax extends BaseHudsonTax
{
    public const RESIDENCY_TAX_RATE = 0.01;
    public const NONRESIDENCY_TAX_RATE = 0.005;
    public const EXEMPTION_AMOUNT = 1000;


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
