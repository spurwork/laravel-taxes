<?php

namespace Appleton\Taxes\Countries\US\Ohio\BerneUnionLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class BerneUnionLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '2302';

    protected function getId(): string
    {
        return self::ID;
    }
}
