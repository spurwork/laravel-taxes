<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\Albion\V20200101;

use Appleton\Taxes\Countries\US\Michigan\Albion\AlbionTax as BaseAlbionTax;

class AlbionTax extends BaseAlbionTax
{
    public const RESIDENCY_TAX_RATE = 0.1;
    public const NONRESIDENCY_TAX_RATE = 0.05;
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
