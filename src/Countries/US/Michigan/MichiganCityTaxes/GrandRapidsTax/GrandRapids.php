<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\GrandRapidsTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTax;

abstract class GrandRapidsTax extends MichiganCityTax
{
    private const CITY_NAME = 'GrandRapids';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
