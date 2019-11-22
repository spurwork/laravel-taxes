<?php

namespace Appleton\Taxes\Countries\US\Ohio\LibertyBentonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class LibertyBentonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3205';

    protected function getId(): string
    {
        return self::ID;
    }
}
