<?php

namespace Appleton\Taxes\Countries\US\Ohio\CloverleafLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class CloverleafLSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '5204';

    protected function getId(): string
    {
        return self::ID;
    }
}
