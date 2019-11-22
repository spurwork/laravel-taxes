<?php

namespace Appleton\Taxes\Countries\US\Ohio\DaltonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class DaltonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8502';

    protected function getId(): string
    {
        return self::ID;
    }
}
