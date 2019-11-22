<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthwoodLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class NorthwoodLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '8706';

    protected function getId(): string
    {
        return self::ID;
    }
}
