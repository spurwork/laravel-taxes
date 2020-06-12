<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\Grayling\V20200101;

use Appleton\Taxes\Countries\US\Michigan\Grayling\GraylingTax as BaseGraylingTax;

class GraylingTax extends BaseGraylingTax
{
    public const RESIDENCY_TAX_RATE = 0.01;
    public const NONRESIDENCY_TAX_RATE = 0.005;
    public const EXEMPTION_AMOUNT = 3000;


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
