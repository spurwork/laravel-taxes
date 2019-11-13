<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewtonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NewtonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5506';

    protected function getId(): string
    {
        return self::ID;
    }
}
