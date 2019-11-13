<?php

namespace Appleton\Taxes\Countries\US\Ohio\SwantonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class SwantonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2606';

    protected function getId(): string
    {
        return self::ID;
    }
}
