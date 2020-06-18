<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\IoniaTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class IoniaTax extends MichiganCityTax
{
    private const CITY_NAME = 'Ionia';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
