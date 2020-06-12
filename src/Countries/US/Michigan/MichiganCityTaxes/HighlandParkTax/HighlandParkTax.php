<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\HighlandParkTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTax;

abstract class HighlandParkTax extends MichiganCityTax
{
    private const CITY_NAME = 'HighlandPark';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
