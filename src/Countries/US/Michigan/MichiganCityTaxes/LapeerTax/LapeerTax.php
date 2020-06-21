<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\LapeerTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class LapeerTax extends MichiganCityTax
{
    private const CITY_NAME = 'Lapeer';

    protected static function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
