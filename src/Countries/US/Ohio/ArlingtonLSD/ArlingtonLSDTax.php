<?php

namespace Appleton\Taxes\Countries\US\Ohio\ArlingtonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class ArlingtonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '3202';

    protected function getId(): string
    {
        return self::ID;
    }
}
