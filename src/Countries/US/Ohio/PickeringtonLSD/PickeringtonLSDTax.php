<?php

namespace Appleton\Taxes\Countries\US\Ohio\PickeringtonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class PickeringtonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2307';

    protected function getId(): string
    {
        return self::ID;
    }
}
