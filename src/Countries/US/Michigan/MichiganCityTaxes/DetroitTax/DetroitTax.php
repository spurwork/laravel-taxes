<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\DetroitTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class DetroitTax extends MichiganCityTax
{
    private const CITY_NAME = 'Detroit';

    protected static function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
