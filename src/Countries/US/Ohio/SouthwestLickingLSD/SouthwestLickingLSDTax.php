<?php

namespace Appleton\Taxes\Countries\US\Ohio\SouthwestLickingLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class SouthwestLickingLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '4510';

    protected function getId(): string
    {
        return self::ID;
    }
}
