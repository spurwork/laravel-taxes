<?php

namespace Appleton\Taxes\Countries\US\Ohio\MinsterLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class MinsterLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '0601';

    protected function getId(): string
    {
        return self::ID;
    }
}
