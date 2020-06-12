<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\GraylingTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTax;

abstract class GraylingTax extends MichiganCityTax
{
    private const CITY_NAME = 'Grayling';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
