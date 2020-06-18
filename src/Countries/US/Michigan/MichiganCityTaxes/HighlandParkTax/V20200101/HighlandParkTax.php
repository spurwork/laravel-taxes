<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\HighlandPark\V20200101;

use Appleton\Taxes\Countries\US\Michigan\HighlandPark\HighlandParkTax as BaseHighlandParkTax;

class HighlandParkTax extends BaseHighlandParkTax
{
    public const RESIDENCY_TAX_RATE = 0.02;
    public const NONRESIDENCY_TAX_RATE = 0.01;
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
