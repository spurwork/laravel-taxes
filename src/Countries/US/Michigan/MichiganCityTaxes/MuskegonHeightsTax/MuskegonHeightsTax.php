<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MuskegonHeightsTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class MuskegonHeightsTax extends MichiganCityTax
{
    private const CITY_NAME = 'MuskegonHeights';

    protected static function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
