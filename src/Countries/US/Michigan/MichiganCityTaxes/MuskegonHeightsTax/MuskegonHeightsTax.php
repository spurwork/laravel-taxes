<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MuskegonHeightsTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTax;

abstract class MuskegonHeightsTax extends MichiganCityTax
{
    private const CITY_NAME = 'MuskegonHeights';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
