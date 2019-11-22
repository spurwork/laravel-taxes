<?php

namespace Appleton\Taxes\Countries\US\Ohio\LibertyUnionThurstonLSD;

use Appleton\Taxes\Countries\US\Ohio\OhioSchoolDistrictTraditionalTax;

abstract class LibertyUnionThurstonLSDTax extends OhioSchoolDistrictTraditionalTax
{
    private const ID = '2306';

    protected function getId(): string
    {
        return self::ID;
    }
}
