<?php

namespace Appleton\Taxes\Countries\US\Ohio\AnnaLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class AnnaLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7501';

    protected function getId(): string
    {
        return self::ID;
    }
}
