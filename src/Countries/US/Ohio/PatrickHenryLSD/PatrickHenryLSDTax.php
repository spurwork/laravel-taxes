<?php

namespace Appleton\Taxes\Countries\US\Ohio\PatrickHenryLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class PatrickHenryLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3504';

    protected function getId(): string
    {
        return self::ID;
    }
}
