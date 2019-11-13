<?php

namespace Appleton\Taxes\Countries\US\Ohio\PerrysburgEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class PerrysburgEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8708';

    protected function getId(): string
    {
        return self::ID;
    }
}
