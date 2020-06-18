<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\DetroitTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTax;

abstract class DetroitTax extends MichiganCityTax
{
    private const CITY_NAME = 'Detroit';

    protected $special_city = true;

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
