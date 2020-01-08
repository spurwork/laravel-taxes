<?php

namespace Appleton\Taxes\Countries\US\Ohio\BloomCarrollLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class BloomCarrollLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2303';

    protected function getId(): string
    {
        return self::ID;
    }
}
