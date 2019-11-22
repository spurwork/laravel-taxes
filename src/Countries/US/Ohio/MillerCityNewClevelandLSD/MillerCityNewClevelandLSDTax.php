<?php

namespace Appleton\Taxes\Countries\US\Ohio\MillerCityNewClevelandLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class MillerCityNewClevelandLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6906';

    protected function getId(): string
    {
        return self::ID;
    }
}
