<?php

namespace Appleton\Taxes\Countries\US\Ohio\MechanicsburgEVSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class MechanicsburgEVSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '1102';

    protected function getId(): string
    {
        return self::ID;
    }
}
