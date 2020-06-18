<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\EastLansingTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class EastLansingTax extends MichiganCityTax
{
    private const CITY_NAME = 'EastLansing';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
