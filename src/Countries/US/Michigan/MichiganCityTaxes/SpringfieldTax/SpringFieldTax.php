<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\SpringfieldTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class SpringfieldTax extends MichiganCityTax
{
    private const CITY_NAME = 'Springfield';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
