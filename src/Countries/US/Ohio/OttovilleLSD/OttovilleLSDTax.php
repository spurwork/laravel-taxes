<?php

namespace Appleton\Taxes\Countries\US\Ohio\OttovilleLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class OttovilleLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6908';

    protected function getId(): string
    {
        return self::ID;
    }
}
