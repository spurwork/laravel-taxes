<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MuskegonTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class MuskegonTax extends MichiganCityTax
{
    private const CITY_NAME = 'Muskegon';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
