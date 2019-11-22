<?php

namespace Appleton\Taxes\Countries\US\Ohio\HardinNorthernLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class HardinNorthernLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3302';

    protected function getId(): string
    {
        return self::ID;
    }
}
