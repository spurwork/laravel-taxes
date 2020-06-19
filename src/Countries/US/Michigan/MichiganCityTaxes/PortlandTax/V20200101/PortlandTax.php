<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\PortlandTax\V20200101;

use Appleton\Taxes\Countries\US\Michigan\PortlandTax\PortlandTax as BasePortlandTax;

class PortlandTax extends BasePortlandTax
{
    public const RESIDENCY_TAX_RATE = 0.01;
    public const NONRESIDENCY_TAX_RATE = 0.005;
    public const EXEMPTION_AMOUNT = 1000;


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
