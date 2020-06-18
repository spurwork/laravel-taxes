<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\Ionia\V20200101;

use Appleton\Taxes\Countries\US\Michigan\Ionia\IoniaTax as BaseIoniaTax;

class IoniaTax extends BaseIoniaTax
{
    public const RESIDENCY_TAX_RATE = 0.01;
    public const NONRESIDENCY_TAX_RATE = 0.005;
    public const EXEMPTION_AMOUNT = 700;


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
