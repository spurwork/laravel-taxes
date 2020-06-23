<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\BigRapidsTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class BigRapidsTax extends MichiganCityTax
{
    private const CITY_NAME = 'BigRapids';

    protected static function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
