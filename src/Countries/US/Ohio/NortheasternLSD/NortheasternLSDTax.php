<?php

namespace Appleton\Taxes\Countries\US\Ohio\NortheasternLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class NortheasternLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '1203';

    protected function getId(): string
    {
        return self::ID;
    }
}
