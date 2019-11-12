<?php

namespace Appleton\Taxes\Countries\US\Ohio\GibsonburgEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictEarnedIncomeTax;

abstract class GibsonburgEVSDTax extends OhioSchoolDistrictEarnedIncomeTax
{
    private const ID = '7203';

    protected function getId(): string
    {
        return self::ID;
    }
}
