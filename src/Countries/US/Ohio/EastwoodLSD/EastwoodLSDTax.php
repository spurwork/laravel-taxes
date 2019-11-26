<?php

namespace Appleton\Taxes\Countries\US\Ohio\EastwoodLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class EastwoodLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '8702';

    protected function getId(): string
    {
        return self::ID;
    }
}
