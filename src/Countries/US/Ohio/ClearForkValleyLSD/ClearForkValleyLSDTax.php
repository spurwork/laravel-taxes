<?php

namespace Appleton\Taxes\Countries\US\Ohio\ClearForkValleyLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class ClearForkValleyLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '7001';

    protected function getId(): string
    {
        return self::ID;
    }
}
