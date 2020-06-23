<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\HighlandParkTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class HighlandParkTax extends MichiganCityTax
{
    private const CITY_NAME = 'HighlandPark';

    protected static function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
