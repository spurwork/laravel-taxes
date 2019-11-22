<?php

namespace Appleton\Taxes\Countries\US\Ohio\LoganElmLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class LoganElmLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '6502';

    protected function getId(): string
    {
        return self::ID;
    }
}
