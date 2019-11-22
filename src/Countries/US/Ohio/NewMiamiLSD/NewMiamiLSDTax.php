<?php

namespace Appleton\Taxes\Countries\US\Ohio\NewMiamiLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NewMiamiLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0907';

    protected function getId(): string
    {
        return self::ID;
    }
}
