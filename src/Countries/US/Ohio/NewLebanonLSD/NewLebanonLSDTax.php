<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewLebanonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NewLebanonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5708';

    protected function getId(): string
    {
        return self::ID;
    }
}
