<?php

namespace Appleton\Taxes\Countries\US\Ohio\RossLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class RossLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '0908';

    protected function getId(): string
    {
        return self::ID;
    }
}
