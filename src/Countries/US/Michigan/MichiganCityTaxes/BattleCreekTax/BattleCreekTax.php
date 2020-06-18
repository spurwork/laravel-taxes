<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\BattleCreekTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class BattleCreekTax extends MichiganCityTax
{
    private const CITY_NAME = 'BattleCreek';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
