<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\Saginaw\V20200101;

use Appleton\Taxes\Countries\US\Michigan\Saginaw\SaginawTax as BaseSaginawTax;

class SaginawTax extends BaseSaginawTax
{
    public const RESIDENCY_TAX_RATE = 0.015;
    public const NONRESIDENCY_TAX_RATE = 0.0075;
    public const EXEMPTION_AMOUNT = 750;


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
