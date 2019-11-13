<?php

namespace Appleton\Taxes\Countries\US\Ohio\McCombLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class McCombLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3206';

    protected function getId(): string
    {
        return self::ID;
    }
}
