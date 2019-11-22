<?php

namespace Appleton\Taxes\Countries\US\Ohio\BethelLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class BethelLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '5501';

    protected function getId(): string
    {
        return self::ID;
    }
}
