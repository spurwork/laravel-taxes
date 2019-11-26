<?php

namespace Appleton\Taxes\Countries\US\Ohio\AntwerpLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class AntwerpLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '6301';

    protected function getId(): string
    {
        return self::ID;
    }
}
