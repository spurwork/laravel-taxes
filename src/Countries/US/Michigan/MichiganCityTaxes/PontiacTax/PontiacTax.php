<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\PontiacTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class PontiacTax extends MichiganCityTax
{
    private const CITY_NAME = 'Pontiac';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
