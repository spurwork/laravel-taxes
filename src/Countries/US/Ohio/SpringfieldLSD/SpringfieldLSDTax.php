<?php

namespace Appleton\Taxes\Countries\US\Ohio\SpringfieldLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class SpringfieldLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5010';

    protected function getId(): string
    {
        return self::ID;
    }
}
