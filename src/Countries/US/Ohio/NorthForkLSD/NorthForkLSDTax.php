<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthForkLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class NorthForkLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '4508';

    protected function getId(): string
    {
        return self::ID;
    }
}
