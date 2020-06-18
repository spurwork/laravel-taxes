<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\JacksonTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class JacksonTax extends MichiganCityTax
{
    private const CITY_NAME = 'Jackson';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
