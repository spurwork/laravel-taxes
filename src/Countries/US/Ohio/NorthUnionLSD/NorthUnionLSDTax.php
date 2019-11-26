<?php

namespace Appleton\Taxes\Countries\US\Ohio\NorthUnionLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class NorthUnionLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '8003';

    protected function getId(): string
    {
        return self::ID;
    }
}
