<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\HamtramckTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class HamtramckTax extends MichiganCityTax
{
    private const CITY_NAME = 'Hamtramck';

    protected static function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
