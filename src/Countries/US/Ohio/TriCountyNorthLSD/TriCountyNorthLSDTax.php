<?php

namespace Appleton\Taxes\Countries\US\Ohio\TriCountyNorthLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class TriCountyNorthLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '6806';

    protected function getId(): string
    {
        return self::ID;
    }
}
