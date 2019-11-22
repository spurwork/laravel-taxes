<?php

namespace Appleton\Taxes\Countries\US\Ohio\SouthwestLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class SouthwestLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '3118';

    protected function getId(): string
    {
        return self::ID;
    }
}
