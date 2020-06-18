<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\PortHuronTax;

use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\MichiganCityTax;

abstract class PortHuronTax extends MichiganCityTax
{
    private const CITY_NAME = 'PortHuron';

    protected function getCityName(): string
    {
        return self::CITY_NAME;
    }
}
