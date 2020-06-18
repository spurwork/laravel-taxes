<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\FlintTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class FlintTax extends MichiganCityTax
{
    private const CITY_NAME = 'Flint';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
