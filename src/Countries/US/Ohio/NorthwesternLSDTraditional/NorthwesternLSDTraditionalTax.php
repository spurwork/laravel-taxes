<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthwesternLSDTraditional;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NorthwesternLSDTraditionalTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8505';

    protected function getId(): string
    {
        return self::ID;
    }
}
