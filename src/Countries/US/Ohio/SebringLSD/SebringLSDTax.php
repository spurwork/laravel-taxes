<?php

namespace Appleton\Taxes\Countries\US\Ohio\SebringLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class SebringLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '5008';

    protected function getId(): string
    {
        return self::ID;
    }
}
