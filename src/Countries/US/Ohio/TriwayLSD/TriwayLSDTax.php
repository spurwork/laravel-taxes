<?php

namespace Appleton\Taxes\Countries\US\Ohio\TriwayLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class TriwayLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '8509';

    protected function getId(): string
    {
        return self::ID;
    }
}
