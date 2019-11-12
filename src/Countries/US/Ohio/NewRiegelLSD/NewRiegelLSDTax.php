<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewRiegelLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NewRiegelLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '7404';

    protected function getId(): string
    {
        return self::ID;
    }
}
