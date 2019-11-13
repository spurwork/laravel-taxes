<?php

namespace Appleton\Taxes\Countries\US\Ohio\SoutheasternLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class SoutheasternLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1205';

    protected function getId(): string
    {
        return self::ID;
    }
}
