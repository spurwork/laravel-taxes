<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\AlbionTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class AlbionTax extends MichiganCityTax
{
    private const CITY_NAME = 'Albion';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
