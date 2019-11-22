<?php

namespace Appleton\Taxes\Countries\US\Ohio\JonathanAlderLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class JonathanAlderLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '4902';

    protected function getId(): string
    {
        return self::ID;
    }
}
