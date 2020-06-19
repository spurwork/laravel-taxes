<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\EastLansingTax\V20200101;

use Appleton\Taxes\Countries\US\Michigan\EastLansingTax\EastLansingTax as BaseEastLansingTax;

class EastLansingTax extends BaseEastLansingTax
{
    public const RESIDENCY_TAX_RATE = 0.01;
    public const NONRESIDENCY_TAX_RATE = 0.005;
    public const EXEMPTION_AMOUNT = 600;


    protected function getResidencyTaxRate(): float
    {
        return self::RESIDENCY_TAX_RATE;
    }

    protected function getNonresidencyTaxRate(): float
    {
        return self::NONRESIDENCY_TAX_RATE;
    }

    protected function getExemptionAmount(): int
    {
        return self::EXEMPTION_AMOUNT;
    }
}
