<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthmorLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NorthmorLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '5904';

    protected function getId(): string
    {
        return self::ID;
    }
}
