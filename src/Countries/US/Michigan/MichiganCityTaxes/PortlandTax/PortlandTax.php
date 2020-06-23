<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\PortlandTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class PortlandTax extends MichiganCityTax
{
    private const CITY_NAME = 'Portland';

    protected static function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
