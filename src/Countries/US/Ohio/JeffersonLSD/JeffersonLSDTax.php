<?php

namespace Appleton\Taxes\Countries\US\Ohio\JeffersonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class JeffersonLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '4901';

    protected function getId(): string
    {
        return self::ID;
    }
}
