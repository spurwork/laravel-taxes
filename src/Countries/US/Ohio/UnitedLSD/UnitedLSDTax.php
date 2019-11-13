<?php

namespace Appleton\Taxes\Countries\US\Ohio\UnitedLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class UnitedLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1510';

    protected function getId(): string
    {
        return self::ID;
    }
}
