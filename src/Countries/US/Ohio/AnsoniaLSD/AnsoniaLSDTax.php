<?php

namespace Appleton\Taxes\Countries\US\Ohio\AnsoniaLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class AnsoniaLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1901';

    protected function getId(): string
    {
        return self::ID;
    }
}
