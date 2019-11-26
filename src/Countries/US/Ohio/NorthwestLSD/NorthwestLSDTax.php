<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthwestLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class NorthwestLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '7612';

    protected function getId(): string
    {
        return self::ID;
    }
}
