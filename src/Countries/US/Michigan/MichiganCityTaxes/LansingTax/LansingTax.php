<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\LansingTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class LansingTax extends MichiganCityTax
{
    private const CITY_NAME = 'Lansing';

    protected static function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
