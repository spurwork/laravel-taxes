<?php

namespace Appleton\Taxes\Countries\US\Ohio\TeaysValleyLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class TeaysValleyLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '6503';

    protected function getId(): string
    {
        return self::ID;
    }
}
